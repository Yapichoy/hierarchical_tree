<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Position;
class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function change($id){
        $employee = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.*', 'positions.denomination','positions.lvl')->where('id',$id)->first();
        $positions = Position::all();
        if($employee['chef_id']!=0) {
            $chef = Employee::leftJoin('positions','employees.position_id','positions._id')
                ->select('employees.id','employees.surname', 'employees.name', 'employees.secondname','positions.denomination','positions.lvl')->where('positions.lvl', $employee['lvl']-1)->get();
        }
       else $chef = null;

        return view('employee.change',compact(['employee','positions','chef']));
    }

    /**
     * @param $request
     */
    private function _validate($request){
        $this->validate($request,[
            'fio' =>'required|max:255',
            'positions' => 'required',
            'date' => 'required',
            'chef' => 'required',
            'salary' => 'required'
        ]);
    }

    /**
     * @param $pos_id
     * @return int
     */
    private function changeChef($pos_id){
        if($pos_id == 1)
            return 0;
        $position = Position::where('_id', $pos_id)->first();
        $chef = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.id','positions.lvl')->where('positions.lvl', $position['lvl']-1)->get();
        $rand = mt_rand(0, count($chef)-1);
        return $chef[$rand]['id'];

    }
    /**
     * @param $employee
     * @param $post
     * @return array
     */
    private function checkUpdates($employee, $post){
        $update = [];
        $position_up = false;
        $fio = explode(' ', $post['fio']);
        if($fio[0] != $employee['surname']) $update['surname'] = $fio[0];
        if($fio[1] != $employee['name']) $update['name'] = $fio[1];
        if($fio[2] != $employee['secondname']) $update['secondname'] = $fio[2];
        if($post['positions'] != $employee['position_id']){ $update['position_id'] = $post['positions']; $position_up = true;}
        if($post['date'] != $employee['date_start_work'])$update['date_start_work'] = $post['date'];
        if($post['salary'] != $employee['salary']) $update['salary'] = $post['salary'];
        if($position_up)$update['chef_id'] = $this->changeChef($post['positions']);
        elseif ($post['chef'] != $employee['chef_id']) $update['chef_id'] = $post['chef'];
        return $update;
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save_change(Request $request){ // оохранить изменения
        $this->_validate($request);
        $post = $request->post();
        $employee = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.*', 'positions.denomination','positions.lvl')->where('id',$post['id'])->first();
        $update = $this->checkUpdates($employee, $post); //прверка на существование изменений
        if(!empty($update))
            Employee::where('id', $post['id'])->update($update);
        return redirect()->back();
    }
    public function save(Request $request){ // добавить нового сотрудника в базу
        $this->_validate($request);
        $post = $request->post();
        $fio = explode(' ', $post['fio']);
        Employee::insert(['surname'=> $fio[0], 'name' => $fio[1], 'secondname'=> $fio[2], 'position_id' => $post['positions'],
        'date_start_work'=>$post['date'] ,'salary'=>$post['salary'],'chef_id' => $post['chef']]);
        $errors['no'] = "нет такого";
        return redirect()->back();
    }
    public function delete($id){
        $subordinate = Employee::select('id', 'position_id')->where('chef_id', $id)->get(); //получаю список подчиненных
        if(count($subordinate)>0){ //если есть подчиненные, то меняем начальника для каждого
            foreach ($subordinate as $value){
                $new_chef = $this->changeChef($value['position_id']);
                Employee::where('id',$value['id'])->update(['chef_id'=>$new_chef]);
            }
        }
        Employee::where('id', $id)->delete();
        return redirect('list');
    }
    public function positions(Request $request){
        $post = $request->post();
        $position = Position::where('_id',$post['position_id'])->first();
        $chefs = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.*','positions.lvl')->where('positions.lvl', $position['lvl']-1)->get();
        print_r(json_encode(['chefs' => $chefs]));
    }
    public function create(){
        $positions = Position::all();
        return view('employee.create', compact('positions'));
    }
}

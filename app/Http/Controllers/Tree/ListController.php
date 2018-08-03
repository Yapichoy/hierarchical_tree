<?php

namespace App\Http\Controllers\Tree;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function _switch($arg){
        $sorting = "surname";
        switch ($arg)
        {
            case "fio":     $sorting = "surname";break;
            case "pos":     $sorting = "lvl";break;
            case "date":    $sorting = "date_start_work";break;
            case "salary":  $sorting = "salary";break;
        }
        return $sorting;
    }
    public function sort(Request $request){
        $post = $request->post();
        //["r-bat"]=> string(3) "pos" ["check"]=> string(7) "on-high" }

        $desc = 'asc';
        if(isset($post['check']))
            $desc = $post['check']=='on-high'? 'asc' : 'desc';
        $sorting = $this->_switch($post['r-bat']);
        $employees = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.*', 'positions.denomination')
            ->orderBy($sorting, $desc)
            ->get();
        $res['employees'] = $employees;
        print_r(json_encode($res));
        //return view('list',compact('employees'));
    }
    public function search(Request $request){
        $post = $request->post();
        $search_input = $post['search-input'];
        switch ($post['s-bat'])
        {
            case "fio":     $fio = explode(' ',$search_input); $search = [['surname','=',$fio[0]],
                ['name','=',$fio[1]], ['secondname','=',$fio[2]]];break;
            case "pos":     $search = [["denomination", '=', $search_input]];break;
            case "date":    $search = [['date_start_work', '=', $search_input]];break;
            case "salary":  $search = [['salary','=',$search_input]];break;
        }

        $employees = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.*', 'positions.denomination')
            ->where($search)
            ->get();
        if(count($employees) != 0)
            $res['employees'] = $employees;
        else $res['employees'] = 'no';
        print_r(json_encode($res));
    }
    public function show(){
        $employees = Employee::leftJoin('positions','employees.position_id','positions._id')
            ->select('employees.*', 'positions.denomination')
            ->get();
        return view('list',compact('employees'));
    }
}

<?php

namespace App\Http\Controllers\Tree;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
class LoadController extends Controller
{

    private function getEmployee1($par_layers){
        $_layer =[];
            foreach ($par_layers as $chef) {
            if(!empty(Employee::where('chef_id', $chef['id'])->get())){
                $_layer[$chef['id']] = Employee::leftJoin('positions','employees.position_id','positions._id')->where('chef_id', $chef['id'])->get();
            }
        }
        return $_layer;
    }
    private function getEmployee2($par_layers){
        $_layer =[];
        foreach ($par_layers as $par_layer) {
            foreach ($par_layer as $chef) {
                if (!empty(Employee::where('chef_id', $chef['id'])->get())) {
                    $_layer[$chef['id']] = Employee::leftJoin('positions', 'employees.position_id', 'positions._id')->where('chef_id', $chef['id'])->get();
                }
            }
        }
        return $_layer;
    }
    public function load(Request $request){

        $chef_id = $request->post('chef_id');
        $third_layer = Employee::leftJoin('positions','employees.position_id','positions._id')->where('chef_id',$chef_id)->get();
        $forth_layer = $this->getEmployee1($third_layer);
        $fifth_layer = $this->getEmployee2($forth_layer);
        //$fifth_layer = null;
        $result['third_layer'] = $third_layer;
        $result['forth_layer'] = $forth_layer;
        $result['fifth_layer'] = $fifth_layer;
        print_r(json_encode($result));
    }
}

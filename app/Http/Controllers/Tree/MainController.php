<?php

namespace App\Http\Controllers\Tree;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
class MainController extends Controller
{
    private function getEmployee($par_layers){
        $_layer =[];
        if(isset($par_layers[0]['id'])){
            foreach ($par_layers as $chef) {
                if(!empty(Employee::where('chef_id', $chef['id'])->get())){
                    $_layer[$chef['id']] = Employee::leftJoin('positions','employees.position_id','positions._id')->where('chef_id', $chef['id'])->get();
                }
            }
        }
        else{
            foreach ($par_layers as $par_layer) {
                foreach ($par_layer as $chef) {
                    if(!empty(Employee::where('chef_id', $chef['id'])->get())){
                        $_layer[$chef['id']] = Employee::leftJoin('positions','employees.position_id','positions._id')->where('chef_id', $chef['id'])->get();
                    }
                }

            }
        }
        return $_layer;
    }
    public function test(){
        $first_layer = Employee::leftJoin('positions','employees.position_id','positions._id')->where('chef_id',0)->paginate(4);
        $second_layer = $this->getEmployee($first_layer);
        return view('home',['first_layers'=>$first_layer,'second_layers'=>$second_layer]);
    }
}

<?php

namespace App\Http\Controllers;


use App\Workflow2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkflowsController2 extends Controller
{
    public function workflow2($id)
    {
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $workflows=Workflow2::where('id_ef',$id)->get()->toArray();
        return response()->json(['results'=> $workflows,'users'=>$users]);
    }
    public function workflow3($id)
    {
        $workflows=Workflow2::where('id_ef',$id)->where('level','<',0)->get()->toArray();
        return response()->json(['results'=> $workflows]);
    }
}

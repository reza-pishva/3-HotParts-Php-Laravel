<?php

namespace App\Http\Controllers;

use App\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkflowsController extends Controller
{
    public function workflow($id)
    {
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $workflows=DB::table('workflows')->where('id_exit',$id)->where('description','!=',null)->get()->toArray();
        return response()->json(['results'=> $workflows,'users'=>$users]);
    }
    public function workflow2($id)
    {
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        $workflows=Workflow::where('id_exit',$id)->where('level','<',0)->get()->toArray();
        return response()->json(['results'=> $workflows,'users'=>$users]);
    }
}

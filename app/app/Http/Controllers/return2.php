<?php

namespace App\Http\Controllers;

use App\Exit_goods_permission;
use App\Goodstype;
use Illuminate\Http\Request;

class return2 extends Controller
{
    public function return2list(){
        $part = auth()->user()->id_request_part;
        $requests=Exit_goods_permission::where('id_request_part',$part)->where('level',-3)->get();
        $goodstypes=Goodstype::all();
        return view('return2list',compact('requests','goodstypes'));
    }
}

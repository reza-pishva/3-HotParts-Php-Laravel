<?php

namespace App\Http\Controllers;

use App\Exit_goods_permission;
use App\Goodstype;
use Illuminate\Http\Request;

class return1 extends Controller
{
    public function return1list(){
        $part = auth()->user()->id_request_part;
        $requests=Exit_goods_permission::where('id_request_part',$part)->where('level',-2)->get();
        $goodstypes=Goodstype::all();
        return view('return1list',compact('requests','goodstypes'));
    }
}

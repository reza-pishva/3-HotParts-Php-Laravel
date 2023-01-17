<?php

namespace App\Http\Controllers;


use App\Goodstype;
use App\Group_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kavenegar\KavenegarApi;

class GoodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $requests=Goodstype::all();
        return view('goods',compact('requests'));
    }
    public function delete($id){
        Goodstype::where('id_goods_type', $id)->delete();
        return response()->json(['success'=>'hi','data'=>$id]);
    }
    public function edit(Request $request)
    {
        $description=$request->description;
        $id_goods_type=$request->id_goods_type;
        Goodstype::where('id_goods_type', $id_goods_type)->update(['description'=>$description]);
        $requests=Goodstype::all();
        return view('goods',compact('requests'));
    }
    public function editform($id)
    {
        $requests=Goodstype::where('id_goods_type', $id)->first();
        $description=$requests->description;
        $id_goods_type=$id;
        return view('goodsedit',compact('description','id_goods_type'));
    }
    public function goodstotal()
    {
        $goods=Goodstype::all();
        return response()->json(['results'=> $goods]);
    }
    public function store(Request $request)
    {
        $goods=new Goodstype();
        $goods->description=$request->input('description');
        $goods->save();
        $id_goods_type = DB::table('goodstypes')->orderBy('id_goods_type', 'DESC')->first()->id_goods_type;
        return response()->json(['success'=>'hi','data'=>$id_goods_type]);
    }
    public function editgoods(Request $request)
    {
        $description=$request->description;
        $id_goods_type=$request->id_goods_type;
        Goodstype::where('id_goods_type', $id_goods_type)->update(['description'=>$description]);
        return response()->json(['results'=>$description]);

    }
}

<?php

namespace App\Http\Controllers;

use App\Requestpart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestpartController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    public function create()
    {
        $requests=Requestpart::all();
        return view('parts',compact('requests'));
    }
    public function edit(Request $request)
    {
        $description=$request->description;
        $id_request_part=$request->id_request_part;
        Requestpart::where('id_request_part', $id_request_part)->update(['description'=>$description]);
        $requests=Requestpart::all();
        return view('parts',compact('requests'));
    }
    public function editform($id)
    {
        $requests=Requestpart::where('id_request_part', $id)->first();
        $description=$requests->description;
        $id_request_part=$id;
        return view('partsedit',compact('description','id_request_part'));
    }
    public function partstotal()
    {
        $parts=Requestpart::all();
        return response()->json(['results'=> $parts]);
    }
    public function store(Request $request)
    {
        $parts=new Requestpart();
        $parts->description=$request->input('description');
        $parts->save();
        $id_request_part = DB::table('requestparts')->orderBy('id_request_part', 'DESC')->first()->id_request_part;
        return response()->json(['success'=>'hi','data'=>$id_request_part]);
    }
    public function editparts(Request $request)
    {
        $description=$request->description;
        $id_request_part=$request->id_request_part;
        Requestpart::where('id_request_part', $id_request_part)->update(['description'=>$description]);
        return response()->json(['results'=>$description]);

    }
    public function delete($id){
        Requestpart::where('id_request_part', $id)->delete();
        return response()->json(['success'=>'hi','data'=>$id]);
    }
}

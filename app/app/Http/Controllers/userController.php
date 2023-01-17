<?php

namespace App\Http\Controllers;

use App\Exit_goods_permission;
use App\Goodstype;
use App\Groupuser;
use App\Requestpart;
use App\Role;
use App\User;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function regform()
    {
        $parts=Requestpart::all();
        $requests=User::all();
        return view('auth.register',compact('parts','requests'));
    }
    public function roletouser()
    {
        $roles=Role::all();
        $users=User::all();
        $person_role=0;
        $person=0;
        return view('roletouser',compact('roles','users','person_role','person'));
    }
    public function recieve_roles($id)
    {
        $roles=Role::all();
        $users=User::where('id', $id)->get();
        $person_role=User_role::where('id_user', $id)->get();
        $person=$id;
        //dd($id);
        return view('roletouser',compact('roles','users','person_role','person'));
    }
    public function getuserinfo($user,$pass)
    {
        $id=DB::table('users')->where('name','=',$user)->where('plain_pass', $pass)->first()->id;
        $name=DB::table('users')->where('name','=',$user)->where('plain_pass', $pass)->first()->name;
        $groupusers=Groupuser::where('id_user',$id)->get()->toArray();
        return response()->json(['group'=> $groupusers,'name'=>$name]);
    }
    public function delete($id)
    {

        User::where('id', $id)->delete();
        $parts=Requestpart::all();
        $requests=User::all();
        return view('auth.register',compact('parts','requests'));
    }
    public function edit(Request $request)
    {
        $f_name=$request->f_name;
        $l_name=$request->l_name;
        $id_request_part=$request->id_request_part;
        $name=$request->name;
        $email=$request->email;
        $id=$request->id;
        User::where('id', $id)->update(['f_name'=>$f_name,'l_name'=>$l_name,'id_request_part'=>$id_request_part,'name'=>$name,'email'=>$email]);
        $parts=Requestpart::all();
        $requests=User::all();
        return view('auth.register',compact('parts','requests'));
    }
    public function editform($id)
    {
        $request=User::where('id', $id)->first();
        $f_name=$request->f_name;
        $l_name=$request->l_name;
        $id_request_part=$request->id_request_part;
        $name=$request->name;
        $email=$request->email;
        $id=$request->id;
        $parts=Requestpart::all();
        return view('useredit',compact('f_name','l_name','name','id_request_part','id','email','parts'));
    }
    public function reset(Request $request)
    {
        $user = Auth::user();
        User::where('id', $user->id)->update(['plain_pass'=>$request->password]);
        $user->password = Hash::make($request->password);
        $user->save();
        $goodstypes=Goodstype::all();
        $requests = Exit_goods_permission::where('level',1)->get();
        return view('test3',compact('requests','goodstypes'));
    }
    public function totalusers()
    {
        $users = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['users'=>$users]);
    }

}

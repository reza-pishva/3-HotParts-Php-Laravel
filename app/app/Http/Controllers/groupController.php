<?php

namespace App\Http\Controllers;

use App\Group_table;
use App\Grouprole;
use App\Groupuser;
use App\Requestpart;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kavenegar\KavenegarApi;


class groupController extends Controller
{

    public function create()
    {
        $groups=Group_table::all()->toArray();
        $users=User::all()->toArray();
        $roles=Role::all()->toArray();
        $parts=Requestpart::all();
        return view('roletogroup14',compact('groups','roles','users','parts'));
    }
    public  function store(Request $request){
        $group=new Group_table();
        $group->gr_name=$request->input('gr_name');
        $group->save();
        $id_gr = DB::table('group_tables')->orderBy('id_gr', 'DESC')->first()->id_gr;
        return response()->json(['success'=>'hi','data'=>$id_gr]);
    }
    public  function store2(Request $request){
        $role=new Role();
        $role->role=$request->input('role');
        $role->role_fa=$request->input('role_fa');
        $role->save();
        $id_role = DB::table('roles')->orderBy('id_role', 'DESC')->first()->id_role;
        return response()->json(['success'=>'hi','data'=>$id_role]);
    }
    public function usertogroup(Request $request)
    {
        $users=$request->data1;
        $total_user=count($users)-1;
        $id_gr=$users[count($users)-1];
        Groupuser::where('id_gr', $id_gr)->delete();
        for($y=0;$y<$total_user;$y++){
            DB::table('groupusers')->insert([
                ['id_gr' => $id_gr, 'id_user' =>$users[$y]],
            ]);
        }
        return response()->json(['success'=>'the information has successfuuly saved']);
    }
    public function roletogroup(Request $request)
    {
        $roles=$request->data2;
        $total_role=count($roles)-1;
        $id_gr=$roles[count($roles)-1];
        Grouprole::where('id_gr', $id_gr)->delete();
        for($y=0;$y<$total_role;$y++){
            DB::table('grouproles')->insert([
                ['id_gr' => $id_gr, 'id_role' =>$roles[$y]],
            ]);
        }
        return response()->json(['success'=>'the information has successfuuly saved']);
    }
    public function group_total()
    {
        $data = DB::table('group_tables')->where('id_gr','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function role_total(Request $request)
    {
        $id_gr=$request->data1;
        $selected=Grouprole::where('id_gr',$id_gr)->get()->toArray();
        $data = DB::table('roles')->where('id_role','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'selected'=>$selected,'id_gr'=>$id_gr]);
    }
    public function user_total2()
    {
        $data = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function user_total(Request $request)
    {
        $id_gr=$request->data1;
        $selected=Groupuser::where('id_gr',$id_gr)->get()->toArray();
        $data = DB::table('users')->where('id','>',0)->get()->toArray();
        return response()->json(['results'=> $data,'selected'=>$selected,'id_gr'=>$id_gr]);
    }
    public function editform1(Request $request)
    {
        $id_gr=$request->input('id_gr');
        $gr_name=$request->input('gr_name');
        Group_table::where('id_gr', $id_gr)->update(['gr_name'=>$gr_name]);
        return response()->json(['success'=>'the information has successfuly saved']);

    }
    public function editform2(Request $request)
    {
        $id_role=$request->input('id_role');
        $role=$request->input('role');
        $role_fa=$request->input('role_fa');
        Role::where('id_role', $id_role)->update(['role'=>$role,'role_fa'=>$role_fa]);
        return response()->json(['success'=>'the information has successfuly saved']);

    }
    public function editform3(Request $request)
    {
        $id_user=$request->input('id');
        $f_name=$request->input('f_name');
        $l_name=$request->input('l_name');
        $name=$request->input('name');
        $email=$request->input('email');
        $mobile=$request->input('mobile');
        $id_request_part=$request->input('id_request_part');
        User::where('id', $id_user)->update(['name'=>$name,'f_name'=>$f_name,'l_name'=>$l_name,'email'=>$email,'id_request_part'=>$id_request_part,'mobile'=>$mobile]);
        return response()->json(['success'=>'the information has successfuly saved']);

    }
    public function delete($id){
        Group_table::where('id_gr', $id)->delete();
        Grouprole::where('id_gr', $id)->delete();
        Groupuser::where('id_gr', $id)->delete();
        $data2 = DB::table('group_tables')->where('id_gr','>',0)->get()->toArray();
        return response()->json(['success'=>'hi','data'=>$id,'data2'=>$data2]);
    }
    public function delete2($id){
        Role::where('id_role', $id)->delete();
        Grouprole::where('id_role', $id)->delete();
        return response()->json(['success'=>'hi','data'=>$id]);
    }
    public function delete3($id){
        $req = DB::table('workflows')->where('id_user',$id)->first();

            User::where('id', $id)->delete();
            Groupuser::where('id_user', $id)->delete();
            return response()->json(['success'=>'hi','data'=>$id]);
    }
    public function group_persons($id)
    {
        $id_gr=$id;
        $data1 = Groupuser::where('id_gr', $id_gr)->get()->toArray();
        $data2 = User::all()->toArray();
        return response()->json(['data1'=> $data1,'data2'=> $data2]);
    }
    public function group_levels($id)
    {
        $id_gr=$id;
        $data1 = Grouprole::where('id_gr', $id_gr)->get()->toArray();
        $data2 = Role::all()->toArray();
        return response()->json(['data1'=> $data1,'data2'=> $data2]);
    }
    public function out()
    {
        Auth::logout();
        $groups=Group_table::all()->toArray();
        $users=User::all()->toArray();
        $roles=Role::all()->toArray();
        $parts=Requestpart::all();
        return view('test3',compact('groups','roles','users','parts'));
    }
    public function mygroup()
    {
        $id_user = auth()->user()->id;
        $groups=DB::table('groupusers')->where('id_user', $id_user)->get()->toArray();
        return response()->json(['results'=> $groups]);
    }
    public function editform4(Request $request)
    {
        $groups=Group_table::all()->toArray();
        $users=User::all()->toArray();
        $roles=Role::all()->toArray();
        $parts=Requestpart::all();
        $name=$request->input('name');
        $user = DB::table('users')->where('name',$name)->first();
        if($user!=null){
            $pass_recovery=$user->pass_recovery;
            if($pass_recovery==0){
                $mobile=$user->mobile;
                $pass=$user->plain_pass;
                $message="کلمه عبور شما: ".$pass;
                User::where('id','>',0)->update(['pass_recovery'=>0]);
                User::where('name', $name)->update(['pass_recovery'=>1]);
                $client=new kavenegarapi(env('KAVEH_NEGAR_API_KEY'));
                $client->Send(env('SENDER_MOBILE'),$mobile,$message);
                return view('test3',compact('groups','roles','users','parts'));
            }

        }
        if($user==null){
            return view('usernotfound');
        }
        if($pass_recovery==1){
            return view('duplicateduser');
        }

    }

    public function select_role_id($role)
    {
        $id_role=Role::where('role',$role)->first();
        return $id_role;
    }
    public function select_group_id($id_role)
    {
        $id_gr=Grouprole::where('id_role',$id_role)->get()->toArray();
        return $id_gr;
    }
    public function select_user_id($id_gr)
    {
        $id_user=Groupuser::where('id_gr',$id_gr)->get()->toArray();
        return $id_user;
    }
    public function select_user_mobile($id_user)
    {
        $mobile=User::where('id',$id_user)->mobile;
        return $mobile;
    }

}

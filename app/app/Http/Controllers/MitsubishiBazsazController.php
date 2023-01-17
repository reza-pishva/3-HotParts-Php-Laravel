<?php
namespace App\Http\Controllers;

use App\Mitsubishi_bazsaz;
use App\Mitsubishi_nirogah_name;
use App\User;
use App\CalendarHelper;
//use App\MitsubishiBazsaz;
use Carbon\Carbon;
use App\Exit_goods_permission;
use App\Form;
use App\Goodstype;
use App\Grouprole;
use App\Groupuser;
use App\Request_level;
use App\Role;
use App\User_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MitsubishiBazsazController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function bazsaz_store(Request $request){
        $id_user=auth()->user()->id;
        $bazsaz= new Mitsubishi_bazsaz();
        $bazsaz->BAZSAZ=$request->input('BAZSAZ');
        $bazsaz->ID_USER=$id_user;
        $bazsaz->save();
        $id_ba = DB::table('mitsubishi_bazsazs')->where('ID_USER',$id_user)->orderBy('ID_BA', 'DESC')->first()->ID_BA;
        return response()->json(['success'=>'hi','id_ba'=>$id_ba]);//,'id_ba'=>$id_ba
    }
    public function create()
    {
                                //--access level-----
                                $user = auth()->user()->id;
                                $f_name=auth()->user()->f_name;
                                $l_name=auth()->user()->l_name;
                                $full_name=$f_name.' '.$l_name;
                                $groupusers=Groupuser::where('id_user',$user)->get()->toArray();
                                $allow=0;
                                foreach ($groupusers as $groupuser) {
                                    $grouproles=Grouprole::where('id_gr',$groupuser['id_gr'])->get()->toArray();
                                    foreach ($grouproles as $grouprole) {
                        
                                        $role_name=Role::where('id_role',$grouprole['id_role'])->first();
                                        if($role_name['role'] ==="admin" or $role_name['role'] ==="track_base_tables"){
                                            $allow=1;
                                            $g_y = Carbon::now()->year;
                                            $g_m = Carbon::now()->month;
                                            $g_d = Carbon::now()->day;
                                            $Calendar=new CalendarHelper();
                                            $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
                                            $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];
                                            $mytime=Carbon::now();
                                            $part = auth()->user()->id_request_part;
                                            $requests=Mitsubishi_bazsaz::all();
                                            $pps=Mitsubishi_nirogah_name::all();
                                            return view('Mitsubishi.mitsubishi_base_tables',compact('requests','pps'));
                                        }
                        
                                    }
                                }
                        
                                if($allow===0){
                                    return view('access_denied');
                                }
                                //--access level-----

    }
    public function bazsaz_total()
    {
        $data = DB::table('mitsubishi_bazsazs')->where('ID_BA','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n= DB::table('mitsubishi_send_bazsazi_ghataats')->where('ID_BA',$id)->get()->count();
        if($n==0){
            Mitsubishi_bazsaz::where('ID_BA', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function bazsaz_edit(Request $request)
    {
        $id_ba=$request->input('ID_BA_EDIT');
        $bazsaz=$request->input('BAZSAZ_EDIT');
//        dd($id_ba);
        Mitsubishi_bazsaz::where('ID_BA', $id_ba)->update([
            'BAZSAZ'=>$bazsaz]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
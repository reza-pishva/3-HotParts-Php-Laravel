<?php
namespace App\Http\Controllers;



use App\Mitsubishi_tamirkaran;
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


class MitsubishiTamirkarController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function tamirkar_store(Request $request){
        $id_user=auth()->user()->id;
        $tamirkar= new Mitsubishi_tamirkaran();
        $tamirkar->TAMIRKAR=$request->input('TAMIRKAR');
        $tamirkar->ID_USER=$id_user;
        $tamirkar->save();
        $id_ta = DB::table('mitsubishi_tamirkarans')->where('ID_USER',$id_user)->orderBy('ID_TA', 'DESC')->first()->ID_TA;
        return response()->json(['success'=>'hi','id_ba'=>$id_ta]);//,'id_ba'=>$id_ba
    }
    public function tamirkar_total()
    {
        $data = DB::table('mitsubishi_tamirkarans')->where('ID_TA','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n= DB::table('mitsubishi_tamirat_programs')->where('ID_TA',$id)->get()->count();
        if($n==0){
            Mitsubishi_tamirkaran::where('ID_TA', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function tamirkar_edit(Request $request)
    {
        $id_se=$request->input('ID_TA_EDIT');
        $seller=$request->input('TAMIRKAR_EDIT');
        Mitsubishi_tamirkaran::where('ID_TA', $id_se)->update(['TAMIRKAR'=>$seller]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
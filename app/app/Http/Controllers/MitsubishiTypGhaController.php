<?php
namespace App\Http\Controllers;



use App\Mitsubishi_type_ghataat;
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


class MitsubishiTypGhaController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $bazsaz= new Mitsubishi_type_ghataat();
        $bazsaz->GHATAAT_NAME=$request->input('GHATAAT_NAME');
        $bazsaz->TIME_STANDARD=$request->input('TIME_STANDARD');
        $bazsaz->TYPE_CODE=$request->input('TYPE_CODE');
        $bazsaz->SET_COUNT=$request->input('SET_COUNT');
        $bazsaz->COUNTB_REJECT=$request->input('COUNTB_REJECT');
        $bazsaz->TIME_REJECT=$request->input('TIME_REJECT');
        $bazsaz->ID_USER=$id_user;
        $bazsaz->save();
        $id_tg = DB::table('mitsubishi_type_ghataats')->where('ID_USER',$id_user)->orderBy('ID_TG', 'DESC')->first()->ID_TG;
        return response()->json(['success'=>'hi','id_tg'=>$id_tg]);//,'id_ba'=>$id_ba
    }
    public function typgha_total()
    {
        $data = DB::table('mitsubishi_type_ghataats')->where('ID_TG','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n1= DB::table('mitsubishi_group_names')->where('ID_TG',$id)->get()->count();
        $n2= DB::table('mitsubishi_buy_ghataats')->where('ID_TG',$id)->get()->count();
        $n3= DB::table('mitsubishi_out_ghataats')->where('ID_TG',$id)->get()->count();
        $n4= DB::table('mitsubishi_send_bazsazi_ghataats')->where('ID_TG',$id)->get()->count();
        $n5= DB::table('mitsubishi_store_program_ins')->where('ID_TG',$id)->get()->count();
        $n=$n1+$n2+$n3+$n4+$n5;
        if($n==0){
            Mitsubishi_type_ghataat::where('ID_TG', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function edit(Request $request)
    {
        $id_tg=$request->input('ID_TG_EDIT');
        $GHATAAT_NAME=$request->input('GHATAAT_NAME_EDIT');
        $TIME_STANDARD=$request->input('TIME_STANDARD_EDIT');
        $TYPE_CODE=$request->input('TYPE_CODE_EDIT');
        $SET_COUNT=$request->input('SET_COUNT_EDIT');
        $COUNTB_REJECT=$request->input('COUNTB_REJECT_EDIT');
        $TIME_REJECT=$request->input('TIME_REJECT_EDIT');

//        dd($id_ba);
        Mitsubishi_type_ghataat::where('ID_TG', $id_tg)->update([
            'GHATAAT_NAME'=>$GHATAAT_NAME,
            'TIME_STANDARD'=>$TIME_STANDARD,
            'TYPE_CODE'=>$TYPE_CODE,
            'SET_COUNT'=>$SET_COUNT,
            'COUNTB_REJECT'=>$COUNTB_REJECT,
            'TIME_REJECT'=>$TIME_REJECT]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
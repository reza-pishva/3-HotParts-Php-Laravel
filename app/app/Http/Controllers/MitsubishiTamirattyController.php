<?php
namespace App\Http\Controllers;


use App\Mitsubishi_tamirat_type;
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


class MitsubishiTamirattyController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function tamiratty_store(Request $request){
        $id_user=auth()->user()->id;
        $bazsaz= new Mitsubishi_tamirat_type();
        $bazsaz->TAMIRAT_TYPE=$request->input('TAMIRAT_TYPE');
        $bazsaz->ID_USER=$id_user;
        $bazsaz->save();
        $id_tt = DB::table('mitsubishi_tamirat_types')->where('ID_USER',$id_user)->orderBy('ID_TT', 'DESC')->first()->ID_TT;
        return response()->json(['success'=>'hi','id_tt'=>$id_tt]);//,'id_ba'=>$id_ba
    }
    public function tamiratty_total()
    {
        $data = DB::table('mitsubishi_tamirat_types')->where('ID_TT','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n= DB::table('mitsubishi_tamirat_programs')->where('ID_TT',$id)->get()->count();
        if($n==0){
            Mitsubishi_tamirat_type::where('ID_TT', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function tamiratty_edit(Request $request)
    {
        $id_tt=$request->input('ID_TT_EDIT');
        $bazsaz=$request->input('TAMIRAT_TYPE_EDIT');
//        dd($id_ba);
        Mitsubishi_tamirat_type::where('ID_TT', $id_tt)->update([
            'TAMIRAT_TYPE'=>$bazsaz]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
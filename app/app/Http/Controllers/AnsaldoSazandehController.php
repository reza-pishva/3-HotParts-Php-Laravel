<?php
namespace App\Http\Controllers;



use App\Ansaldo_sazandeh;
use App\Ansaldo_tamirkaran;
use App\User;
use App\CalendarHelper;
//use App\AnsaldoBazsaz;
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


class AnsaldoSazandehController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $tamirkar= new Ansaldo_sazandeh();
        $tamirkar->SAZANDEH=$request->input('SAZANDEH');
        $tamirkar->ID_USER=$id_user;
        $tamirkar->save();
        return response()->json(['success'=>'hi']);//,'id_ba'=>$id_ba
    }
    public function total()
    {
        $data = DB::table('ansaldo_sazandehs')->where('ID_S','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n= DB::table('ansaldo_ghataats')->where('MAKER',$id)->get()->count();
        if($n==0){
            Ansaldo_sazandeh::where('ID_S', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }
    }
    public function edit(Request $request)
    {
        $id_s=$request->input('ID_S_EDIT');
        $SAZANDEH=$request->input('SAZANDEH_EDIT');
        Ansaldo_sazandeh::where('ID_S', $id_s)->update(['SAZANDEH'=>$SAZANDEH]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
<?php
namespace App\Http\Controllers;


use App\Ansaldo_seller;
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


class AnsaldoSellerController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function seller_store(Request $request){
        $id_user=auth()->user()->id;
        $seller= new Ansaldo_seller();
        $seller->SELLER=$request->input('SELLER');
        $seller->ID_USER=$id_user;
        $seller->save();
        $id_se = DB::table('ansaldo_sellers')->where('ID_USER',$id_user)->orderBy('ID_SE', 'DESC')->first()->ID_SE;
        return response()->json(['success'=>'hi','id_ba'=>$id_se]);//,'id_ba'=>$id_ba
    }
    public function seller_total()
    {
        $data = DB::table('ansaldo_sellers')->where('ID_SE','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $n= DB::table('ansaldo_buy_ghataats')->where('ID_SE',$id)->get()->count();
        if($n==0){
            Ansaldo_seller::where('ID_SE', $id)->delete();
            return response()->json(['success'=>'hi','n'=>$n]);
        }else{
            return response()->json(['success'=>'hi','n'=>$n]);
        }

    }
    public function seller_edit(Request $request)
    {
        $id_se=$request->input('ID_SE_EDIT');
        $seller=$request->input('SELLER_EDIT');
        Ansaldo_seller::where('ID_SE', $id_se)->update(['SELLER'=>$seller]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
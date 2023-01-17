<?php
namespace App\Http\Controllers;

use App\Ansaldo_unit_number;
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


class AnsaldoUniNuController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $NIR= new Ansaldo_unit_number();
        $NIR->UNIT_NUMBER=$request->input('UNIT_NUMBER');
        $NIR->unitNumberDigit=$request->input('unitNumberDigit');
        $NIR->ID_NN=$request->input('ID_NN');
        $NIR->ID_USER=$id_user;
        $NIR->save();
        $id_nn = DB::table('ansaldo_unit_numbers')->where('ID_USER',$id_user)->orderBy('ID_UN', 'DESC')->first()->ID_UN;
        return response()->json(['success'=>'hi','id_un'=>$id_nn]);
    }
    public function total()
    {
        $data = DB::table('ansaldo_unit_numbers')->where('ID_UN','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $id_user=auth()->user()->id;
        $id_nn = DB::table('ansaldo_unit_numbers')->where('ID_USER',$id_user)->orderBy('ID_UN', 'DESC')->first()->ID_UN;
        Ansaldo_unit_number::where('ID_UN', $id)->delete();
        return response()->json(['success'=>'hi','id_un'=>$id_nn]);
    }
    public function edit(Request $request)
    {
        $id_nn=$request->input('ID_UN_EDIT');
        $UNIT_NUMBER_EDIT=$request->input('UNIT_NUMBER_EDIT');
        $ID_NN_EDIT=$request->input('ID_NN_EDIT');
        $unitNumberDigit_EDIT=$request->input('unitNumberDigit_EDIT');
        Ansaldo_unit_number::where('ID_UN', $id_nn)->update([
            'UNIT_NUMBER'=>$UNIT_NUMBER_EDIT,
            'ID_NN'=>$ID_NN_EDIT,
            'unitNumberDigit'=>$unitNumberDigit_EDIT]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
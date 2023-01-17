<?php
namespace App\Http\Controllers;
use App\Ansaldo_nirogah_name;
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


class AnsaldoNirNaController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){
        $id_user=auth()->user()->id;
        $NIR= new Ansaldo_nirogah_name();
        $NIR->NIROGAH_NAME=$request->input('NIROGAH_NAME');
        $NIR->ID_USER=$id_user;
        $NIR->save();
        $id_nn = DB::table('ansaldo_nirogah_names')->where('ID_USER',$id_user)->orderBy('ID_NN', 'DESC')->first()->ID_NN;
        return response()->json(['success'=>'hi','id_nn'=>$id_nn]);
    }
    public function total()
    {
        $data = DB::table('ansaldo_nirogah_names')->where('ID_NN','>',0)->get()->toArray();
        return response()->json(['results'=> $data]);
    }
    public function delete($id){
        $id_user=auth()->user()->id;
        $id_nn = DB::table('ansaldo_nirogah_names')->where('ID_USER',$id_user)->orderBy('ID_NN', 'DESC')->first()->ID_NN;
        Ansaldo_nirogah_name::where('ID_NN', $id)->delete();
        return response()->json(['success'=>'hi','id_nn'=>$id_nn]);
    }
    public function edit(Request $request)
    {
        $id_nn=$request->input('ID_NN_EDIT');
        $NIROGAH_NAME=$request->input('NIROGAH_NAME_EDIT');
        Ansaldo_nirogah_name::where('ID_NN', $id_nn)->update(['NIROGAH_NAME'=>$NIROGAH_NAME]);
        return response()->json(['success'=>'the information has successfuly saved']);
    }

}
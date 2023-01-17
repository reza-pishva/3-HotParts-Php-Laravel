<?php

namespace App\Http\Controllers;

use App\Entering_personel_unique;
use App\Enteringpeaple;
use Illuminate\Support\Facades\DB;

class enteringPersonelUniqueController extends Controller
{
    public  function store(){
        Entering_personel_unique::where('id_epu','>',0)->delete();
        $personels= Enteringpeaple::where('id_ep','>',0)->get()->toArray();
                foreach($personels as $personel){
                    $n=Entering_personel_unique::where('code_melli',$personel['code_melli'])->get()->count();
                    if($n == 0){
                        DB::table('entering_personel_uniques')->insert([
                            'f_name' => $personel['f_name'],
                            'l_name' => $personel['l_name'],
                            'code_melli' => $personel['code_melli']
                        ]);
                    }
                }
    }
}

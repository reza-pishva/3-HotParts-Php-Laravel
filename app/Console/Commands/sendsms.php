<?php

namespace App\Console\Commands;

use App\CalendarHelper;
use App\Exit_goods_permission;
use App\Grouprole;
use App\Groupuser;
use App\Requestpart;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kavenegar\KavenegarApi;

class sendsms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $client=new kavenegarapi(env('KAVEH_NEGAR_API_KEY'));
//        $client->Send(env('SENDER_MOBILE'),"09171168741","سلام");
        //

        $mobile = array();
        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];

        $requests=Exit_goods_permission::where('level',1)->get()->toArray();
        foreach ($requests as $request) {
            $id_request_part=$request['id_request_part'];
            $id_role=Role::where('role',"first_level_confirmation")->first()->id_role;
            $id_grs=Grouprole::where('id_role',$id_role)->get()->toArray();
            $id_users=Groupuser::where('id_gr',$id_grs[0]['id_gr'])->get()->toArray();
            //dd($id_users);
            foreach ($id_users as $id_user){
                $target = DB::table('users')->where('id',$id_user['id_user'])->get()->toArray();
                $id_request_part3=$target[0]->id_request_part;

                if($id_request_part3==$id_request_part){
                    array_push($mobile, $target[0]->mobile);
                    $values = array('date_shamsi_sms' => $date_shamsi,'time_sms' =>'1','id_user' => $id_user['id_user'],'description' => '1','mobile' =>  $target[0]->mobile);
                    DB::table('smslists')->insert($values);
                }
            }
        }
    }
}

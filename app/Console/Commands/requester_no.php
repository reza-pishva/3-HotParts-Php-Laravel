<?php

namespace App\Console\Commands;

use App\CalendarHelper;
use App\Exit_goods_permission;
use App\Grouprole;
use App\Groupuser;
use App\Role;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class requester_no extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requester:no';

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
        $mobile = [];

        date_default_timezone_set('Asia/Tehran');
        $g_y = Carbon::now()->year;
        $g_m = Carbon::now()->month;
        $g_d = Carbon::now()->day;
        $Calendar=new CalendarHelper();
        $date_shamsi_array=$Calendar->gregorian_to_jalali($g_y, $g_m, $g_d);
        $date_shamsi=$date_shamsi_array[0].'/'.$date_shamsi_array[1].'/'.$date_shamsi_array[2];

        $id_role=Role::where('role',"request_sending")->first()->id_role;
        $id_grs=Grouprole::where('id_role',$id_role)->get()->toArray();
        $id_users=Groupuser::where('id_gr',$id_grs[0]['id_gr'])->get()->toArray();
        $requests=Exit_goods_permission::where('level',-1)->get()->toArray();
        foreach ($requests as $request) {
            $id_user_tatget=$request['id_requester'];
            foreach ($id_users as $id_user){
                $target = DB::table('users')->where('id',$id_user['id_user'])->get()->toArray();
                if($id_user['id_user']==$id_user_tatget){
                    if(in_array($target[0]->mobile, $mobile))
                    {
                        continue;
                    }
                    else
                    {
                        array_push($mobile, $target[0]->mobile);
                        $values = array('date_shamsi_sms' => $date_shamsi,'id_user' => $id_user['id_user'],'description' => 'به نرم افزار مدیریت دریافت مجوز ورود و خروج بخش موارد تایید نشده مراجعه شود','mobile' => $target[0]->mobile);
                        DB::table('smslists')->insert($values);
                    }
                }
           }
        }
    }
}

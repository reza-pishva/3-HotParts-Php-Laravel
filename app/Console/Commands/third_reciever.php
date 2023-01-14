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

class third_reciever extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'third:reciever';

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
//        $requests=Exit_goods_permission::where('level',3)->get()->toArray();
        $rows = DB::table('exit_goods_permissions')->where('level',3)->count();
//        $values = array('date_shamsi_sms' => 1,'id_user' => 1,'description' => $rows,'mobile' => 1);
//        DB::table('smslists')->insert($values);
        if($rows>0){
            $payload = array(
                'to' => 'ExponentPushToken[zxM9aEKZ0xcKJ2q0xmnsNf]',
                'sound' => 'default',
                'body' =>  $rows.' '.'درخواست جدید در کارتابل موارد دریافتی نرم افزار مدیریت ورود و خروج کالا و تجهیزات',
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Accept-Encoding: gzip, deflate",
                    "Content-Type: application/json",
                    "cache-control: no-cache",
                    "host: exp.host"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

    }
}

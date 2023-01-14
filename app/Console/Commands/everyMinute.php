<?php

namespace App\Console\Commands;

use App\Car;
use Illuminate\Console\Command;

class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car:insert1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'inserting in workflow table every minute';

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
        $works=new Car();
        $works->car_no=1;
        $works->driver_name=2;
        $works->save();
    }
}

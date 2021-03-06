<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Nova\Statistics\Statistic;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        $exists = Storage::has('/hant/uploads/images/avatars/202110/08/1_1633662763_NK74tcBHxc.jpeg');
        dd($exists);
    }
    protected function getRandomTime(){
        return date('Y-m-d',strtotime(random_int(-14,-2).' days'));
    }

}

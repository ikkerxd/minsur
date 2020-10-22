<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClosedInscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'closed:inscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para poner le nro de vacantes en 0';

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
     * @return mixed
     */
    public function handle()
    {
        DB::table('inscriptions')
            ->join('courses', 'courses.id', '=', 'inscriptions.id_course')
            ->where('inscriptions.startDate', date('Y-m-d'))
            ->where('courses.id_unity', '4')
            ->update(['inscriptions.slot' => '0']);
        Log::info('se cerro las inscripciones a las 6');
    }
}

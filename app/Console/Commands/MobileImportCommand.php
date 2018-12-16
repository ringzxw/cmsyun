<?php

namespace App\Console\Commands;

use App\Services\CustomerService;
use App\Services\StatementService;
use App\Services\Traits\ServicesTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class MobileImportCommand extends Command
{
    use ServicesTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobile:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '号码导入';


    /**
     * CustomerImportCommand constructor.
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
        $this->getMobileService()->import();
    }
}

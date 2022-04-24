<?php

namespace App\Console\Commands;

use App\Api\Modules\Auth\Entities\Repositories\UserRepository;
use Exception;
use Illuminate\Console\Command;

class ResetCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset User Credit Credit';

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
    public function handle(UserRepository $userRepo)
    {
        $result = $userRepo->resetCredit();
        if ($result) {
            $this->info("Reset Credit success");
        } else {
            $this->error("Reset Credit Failed, Please Check Log for detail");
        }
        return 0;
    }
}

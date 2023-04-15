<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EtherscanController;
use Illuminate\Http\Request;

class FetchSuccessfulTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:successful-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch successful transactions from Etherscan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $etherscanController = new EtherscanController();
        $request = new Request();
        $etherscanController->getSuccessfulTransactions($request);

        $this->info('Successful transactions fetched successfully.');

        return 0;
    }
}

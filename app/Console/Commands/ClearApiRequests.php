<?php

namespace App\Console\Commands;

use App\Models\ApiRequest;
use Illuminate\Console\Command;

class ClearApiRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-api-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the ApiRequest table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ApiRequest::truncate();
        $this->info('ApiRequest table cleared.');
    }
}

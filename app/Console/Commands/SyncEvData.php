<?php

namespace App\Console\Commands;

use App\Services\ScraperService;
use Illuminate\Console\Command;

class SyncEvData extends Command
{
    protected $signature = 'sync';

    protected $description = 'Syncs with ChargePlace Scotland API';

    public function __construct(private ScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Stating sync...');
        $this->scraperService->syncChargers();
        $this->info('Sync complete');

        $this->info('Stating status sync...');
        $this->scraperService->getChargerStatuses();
        $this->info('Status sync complete');
    }
}

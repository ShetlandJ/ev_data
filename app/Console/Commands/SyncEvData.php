<?php

namespace App\Console\Commands;

use App\Models\StatusChange;
use Illuminate\Console\Command;
use App\Services\ScraperService;

class SyncEvData extends Command
{
    // add optional dropDB parameter
    protected $signature = 'sync {--dropDB}';

    protected $description = 'Syncs with ChargePlace Scotland API';

    public function __construct(private ScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Stating sync...');
        // $this->scraperService->syncChargers();
        $this->info('Sync complete');

        $this->info('Stating status sync...');

        if ($this->option('dropDB')) {
            StatusChange::truncate();
        }

        // generate progress bar
        $bar = $this->output->createProgressBar(count($this->shetlandChargePoints()));
        foreach ($this->shetlandChargePoints() as $chargePointId) {
            $bar->advance();
            $this->scraperService->getChargerStatuses($chargePointId);
        }
        $bar->finish();
        $this->info('Status sync complete');
    }

    public function shetlandChargePoints()
    {
        return [
            54110,
            52913,
            52914,
            53649,
            50723,
            50722,
            50721,
            50720,
            52174,
            52172,
            51173,
            51635,
            51192,
            51193,
            51177,
            52173,
            51194,
            51172,
            51174,
            60027,
            60049,
            60050,
            60030,
            60811,
            60816,
            60813,
            60812,
        ];
    }
}

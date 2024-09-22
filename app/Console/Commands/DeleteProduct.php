<?php

namespace App\Console\Commands;

use App\Models\FlashSaleModel;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete product flash sale';

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
        $now = Carbon::now();
        FlashSaleModel::where('time_end', '<', $now)->delete();
        $this->info('Expired sales deleted.');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Antrean;
use Illuminate\Console\Command;

class CancelExpiredQueues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antrean:cancel-expired {--hours=24}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Batalkan antrean yang menunggu lebih dari N jam pada hari sebelumnya';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = (int) $this->option('hours');
        $yesterday = now()->subDay()->toDateString();

        // Cancel antrean yang belum selesai dari hari kemarin
        $cancelled = Antrean::where('status', 'menunggu')
            ->whereDate('created_at', $yesterday)
            ->update([
                'status' => 'batal',
                'waktu_selesai' => now(),
            ]);

        $this->info("Total antrean yang dibatalkan: {$cancelled}");

        return Command::SUCCESS;
    }
}

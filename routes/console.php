<?php

use App\Models\Antrian;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $dibatalkan = Antrian::cancelExpiredWaitingQueues();

    if ($dibatalkan > 0) {
        Log::info('Auto-cancel antrean menunggu hari sebelumnya berhasil dijalankan.', [
            'jumlah_dibatalkan' => $dibatalkan,
        ]);
    }
})->dailyAt('00:01')->name('antrian:auto-cancel-expired-menunggu');

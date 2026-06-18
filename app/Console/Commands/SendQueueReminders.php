<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Antrean;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class SendQueueReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-queue-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queue reminders for upcoming bookings and walk-ins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // 1. Remind Bookings (within 24 hours)
        $bookings = Antrean::where('is_booking', true)
            ->where('status', 'menunggu')
            ->where('is_notified_time', false)
            ->whereDate('tanggal_booking', '>=', $now->toDateString())
            ->get();

        foreach ($bookings as $booking) {
            $bookingTime = Carbon::parse($booking->tanggal_booking . ' ' . $booking->waktu_booking);
            $diffMins = $now->diffInMinutes($bookingTime, false);
            
            // If booking is within 24 hours (1440 mins) and in the future
            if ($diffMins > 0 && $diffMins <= 1440) {
                if ($booking->user && $booking->user->no_whatsapp) {
                    WhatsAppService::sendPengingatWaktu($booking->user->no_whatsapp, $booking, 'booking');
                }
                $booking->update(['is_notified_time' => true]);
                $this->info("Reminded booking ID {$booking->id}");
            }
        }

        // 2. Remind Walk-ins (estimated time left 30-45 mins)
        $walkins = Antrean::where('is_booking', false)
            ->where('status', 'menunggu')
            ->where('is_notified_time', false)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'asc')
            ->get();

        $sedangDilayani = Antrean::getQueueBeingServed();
        $baseMinsLeft = 0;
        if ($sedangDilayani) {
            $elapsed = $now->diffInMinutes($sedangDilayani->updated_at);
            $baseMinsLeft = max(0, $sedangDilayani->total_estimasi_waktu - $elapsed);
        }

        $accumulatedMins = $baseMinsLeft;
        foreach ($walkins as $walkin) {
            // Check if accumulated mins is between 30 and 45
            if ($accumulatedMins >= 30 && $accumulatedMins <= 45) {
                if ($walkin->user && $walkin->user->no_whatsapp) {
                    WhatsAppService::sendPengingatWaktu($walkin->user->no_whatsapp, $walkin, 'walkin');
                }
                $walkin->update(['is_notified_time' => true]);
                $this->info("Reminded walkin ID {$walkin->id}");
            }

            // add this queue's time for the next iteration
            $accumulatedMins += $walkin->total_estimasi_waktu;
        }

        $this->info("Reminders checked successfully.");
    }
}

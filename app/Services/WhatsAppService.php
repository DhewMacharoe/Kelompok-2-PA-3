<?php

namespace App\Services;

use App\Models\Antrean;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a notification when the queue is being called
     */
    public static function sendPanggilan(string $noWa, Antrean $antrean)
    {
        $nama = $antrean->nama_pelanggan;
        $nomor = $antrean->nomor_antrean_seq;
        
        $pesan = "Halo *$nama*,\n\nGiliran antrean nomor *$nomor* Anda sedang dipanggil sekarang. Silakan menuju kursi layanan.\n\nTerima kasih,\nArga Home's Barbershop";
        
        return self::sendMessage($noWa, $pesan);
    }

    /**
     * Send a notification when the queue is cancelled
     */
    public static function sendBatal(string $noWa, Antrean $antrean, string $alasan)
    {
        $nama = $antrean->nama_pelanggan;
        $nomor = $antrean->nomor_antrean_seq;
        
        $pesan = "Mohon maaf *$nama*,\n\nAntrean nomor *$nomor* Anda telah dibatalkan oleh Admin.\nAlasan pembatalan: *$alasan*.\n\nJika ada pertanyaan, silakan hubungi admin kami.\n\nTerima kasih,\nArga Home's Barbershop";
        
        return self::sendMessage($noWa, $pesan);
    }

    /**
     * Helper to send HTTP POST to Fonnte
     */
    private static function sendMessage(string $target, string $message)
    {
        $token = env('FONNTE_TOKEN');
        
        // If token is not set, log it and return false (don't break the app)
        if (!$token) {
            Log::warning('WhatsApp Notification not sent. FONNTE_TOKEN is empty.');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Optional, defaults to auto-detect
            ]);

            $result = $response->json();
            
            if (isset($result['status']) && $result['status'] == true) {
                return true;
            } else {
                Log::error('Fonnte Error: ' . json_encode($result));
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}

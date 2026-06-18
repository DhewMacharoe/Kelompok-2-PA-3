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
     * Send a notification when booking/queue is successful
     */
    public static function sendSuksesBooking(string $noWa, Antrean $antrean, int $sisaAntrean)
    {
        $nama = $antrean->nama_pelanggan;
        $nomor = $antrean->nomor_antrean_seq;
        $layanan = $antrean->layanan1?->nama . ($antrean->layanan2 ? ' & ' . $antrean->layanan2->nama : '');
        $estWaktu = $antrean->total_estimasi_waktu;
        
        $pesan = "Halo *$nama*,\n\nPendaftaran antrean Anda berhasil!\n\n*Nomor Antrean:* $nomor\n*Layanan:* $layanan\n*Estimasi Waktu Pelayanan:* $estWaktu Menit\n*Sisa Antrean di Depan Anda:* $sisaAntrean Orang\n\nAnda dapat mengecek status antrean secara langsung melalui website kami.\n\nTerima kasih,\nArga Home's Barbershop";
        
        return self::sendMessage($noWa, $pesan);
    }

    /**
     * Send a notification when queue is 1-2 numbers away
     */
    public static function sendPengingatDekat(string $noWa, Antrean $antrean, int $jarak)
    {
        $nama = $antrean->nama_pelanggan;
        $nomor = $antrean->nomor_antrean_seq;
        
        $pesan = "Halo *$nama*,\n\nGiliran Anda sebentar lagi tiba! (Tersisa *$jarak antrean* di depan Anda).\n\nNomor Antrean Anda: *$nomor*\nMohon bersiap atau segera kembali ke ruang tunggu Barbershop.\n\nTerima kasih,\nArga Home's Barbershop";
        
        return self::sendMessage($noWa, $pesan);
    }

    /**
     * Send a notification when queue is finished
     */
    public static function sendSelesai(string $noWa, Antrean $antrean)
    {
        $nama = $antrean->nama_pelanggan;
        
        $pesan = "Halo *$nama*,\n\nPelayanan Anda telah selesai. Terima kasih telah mempercayakan gaya rambut Anda di *Arga Home's Barbershop*!\n\nJika Anda puas dengan pelayanan kami, mohon kesediaannya untuk memberikan bintang 5 dan ulasan melalui tautan berikut:\nhttps://maps.google.com/?cid=YOUR_GOOGLE_MAPS_LINK\n\nSampai jumpa kembali!\nArga Home's Barbershop";
        
        return self::sendMessage($noWa, $pesan);
    }

    /**
     * Send time-based reminder (H-1 or 30 mins before)
     */
    public static function sendPengingatWaktu(string $noWa, Antrean $antrean, string $tipe)
    {
        $nama = $antrean->nama_pelanggan;
        $nomor = $antrean->nomor_antrean_seq;
        
        if ($tipe === 'booking') {
            $waktu = \Carbon\Carbon::parse($antrean->tanggal_booking . ' ' . $antrean->waktu_booking)->translatedFormat('l, d F Y H:i');
            $pesan = "Halo *$nama*,\n\nIni adalah pengingat bahwa Anda memiliki jadwal booking di *Arga Home's Barbershop*.\n\n*Waktu:* $waktu\n*Nomor Antrean:* $nomor\n\nMohon datang tepat waktu. Jika ingin membatalkan, silakan lakukan melalui website kami.\n\nTerima kasih,\nArga Home's Barbershop";
        } else {
            $pesan = "Halo *$nama*,\n\nIni adalah pengingat bahwa estimasi giliran antrean Anda (Nomor *$nomor*) tinggal 30-45 menit lagi. Mohon segera menuju ke lokasi Barbershop agar tidak terlewat.\n\nTerima kasih,\nArga Home's Barbershop";
        }
        
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

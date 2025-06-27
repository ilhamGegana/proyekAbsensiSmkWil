<?php

namespace App\Jobs;

use App\Models\Notifikasi;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotifikasiAlpha implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Notifikasi $notif) {}

    public function handle(FonnteService $fonnte)
    {
        $res = $fonnte->send($this->notif->tujuan, $this->notif->pesan);

        $this->notif->update([
            'status_kirim' => $res['status'] ? 'sent' : 'failed',
            'response'     => $res,
            'waktu_kirim'  => $res['status'] ? now() : null,
        ]);
    }
}
<?php

namespace App\Events;

use App\Models\Antrean;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntreanListUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $antreanList;
    public function __construct($antreanList)

    {
        $this->antreanList = $antreanList;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channel = 'AntreanList-channel';
        
        $barbershopId = null;
        if (is_iterable($this->antreanList) && count($this->antreanList) > 0) {
            $first = $this->antreanList->first();
            if ($first && isset($first->barbershop_id)) {
                $barbershopId = $first->barbershop_id;
            }
        }
        
        if (!$barbershopId) {
            $barbershopId = app()->bound('currentTenantId') ? app('currentTenantId') : session('current_barbershop_id');
        }

        if ($barbershopId) {
            $channel .= '.' . $barbershopId;
        }

        return [
            new Channel($channel),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'antreanList' => $this->antreanList,
        ];
    }
}

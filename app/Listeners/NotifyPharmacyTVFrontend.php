<?php

namespace App\Listeners;

use App\Events\PharmacyTVUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyPharmacyTVFrontend
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PharmacyTVUpdate  $event
     * @return void
     */
    public function handle(PharmacyTVUpdate $event)
    {
        // আপনি এখানে ডাটা প্রসেস করতে পারেন, যেমন:
        Log::info('PharmacyTVUpdate Event Received:');
    }
}

<?php

namespace App\Listeners;

use Log;
use App\Events\TVUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyTVFrontend
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
     * @param  TVUpdate  $event
     * @return void
     */
    public function handle(TVUpdate $event)
    {

        // আপনি এখানে ডাটা প্রসেস করতে পারেন, যেমন:
        Log::info('TVUpdate Event Received:');
    }
}

<?php

namespace App\Listeners;

use App\Events\SeriesCreated as EventsSeriesCreated;
use App\Mail\SeriesCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailUsersAboutSeriesCreated implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventsSeriesCreated $event): void
    {
        $users = User::all();
        $time = now()->addSeconds(10);

        foreach ($users as $user) {
            //Mail::to(['name'=>'pedro', 'email'='teste@gmail.com'])->send()
            Mail::to($user)->later($time->addSeconds(10), new SeriesCreated(
                nomeSerie: $event->seriesName,
                id: $event->seriesId,
                qtdTemporadas: $event->seriesSeasonsQty,
                epPorTemporada: $event->seriesEpisodesPerSeason
            ));
        }
    }
}

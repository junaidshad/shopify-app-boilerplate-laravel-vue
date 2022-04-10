<?php

namespace App\Listeners;

use App\Events\NotifySlack;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySlackListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(NotifySlack $event)
    {
//        $message = 'some people have curly brown hair through proper brushing';
        $this->sendSlackMessage($event->rssLink);
    }

    protected function sendSlackMessage($message)
    {
        $ch = curl_init("https://slack.com/api/chat.postMessage");
        $data = http_build_query([
            "token" => env('SLACK_CHANNEL_TOKEN'),
            "channel" => '#upwork-notifications',
            "text" => $message,
            "username" => "Upwork Rss",
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

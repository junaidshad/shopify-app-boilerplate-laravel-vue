<?php

namespace App\Jobs;

use App\Events\NotifySlack;
use App\Models\RssTracker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vedmant\FeedReader\Facades\FeedReader;

class ProcessRss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The rssTracker instance.
     *
     * @var \App\Models\RssTracker
     */
    protected $rssTracker;

    /**
     * Create a new job instance.
     *
     * @param RssTracker $rssTracker
     */
    public function __construct(RssTracker $rssTracker)
    {
        try {
            $this->rssTracker = $rssTracker;
        }catch (ModelNotFoundException $e) {
            $e->getMessage();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $config = json_decode($this->rssTracker['configuration']);
            $latestPostLink = isset($config->latestPostLink) ? $config->latestPostLink : null;
            $iterator = 0;

            $feed = FeedReader::read($config->rssLink);
            foreach ($feed->get_items(0, 1) as $item) {
                if($iterator == 0) {
                    if($item->get_link() === $latestPostLink) {
                        break;
                    }else {
                        $config->latestPostLink = $item->get_link();
                        $this->rssTracker['configuration'] = json_encode($config);
                        $this->rssTracker->save();
                    }
                }
                $iterator++;
                event(new NotifySlack($item->get_link()));
            }

            ProcessRss::dispatch($this->rssTracker)->delay(now()->addMinute(1));
        }catch (ModelNotFoundException $exception){
            print("<pre>".print_r($exception->getMessage(),true)."</pre>");
        }
    }
}

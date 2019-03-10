<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Clip;
use App\Http\Controllers\ClipController;

class StoreNewClips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $clips;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Object $clips)
    {
		$this->clips = $clips;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

		foreach ($this->clips as $clip) {

			if (Clip::where('twitch_clip_id', $clip->id)->doesntExist()) {
				ClipController::add_clip($clip);
			}

		}

    }
}

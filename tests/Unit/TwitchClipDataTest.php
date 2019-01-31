<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\ClipController;

class TwitchClipDataTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTwitchClipData()
    {
        $cc = new ClipController;
        $data = $cc->getClipDetails("DelightfulFreezingAlligatorDatBoi");

        $this->assertTrue($data->tracking_id != "");

    }
}

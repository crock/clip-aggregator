<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Clip extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tracking_id' => $request->tracking_id,
            'title' => $request->title,
            'url' => $request->url,
            'embed_url' => $request->embed_url,
            'slug' => $request->slug,
            'game' => $request->game,
            'language' => $request->language,
            'views' => $request->views,
            'duration' => $request->duration,
            'created_at' => $request->created_at,

            'broadcaster_id' => $request['broadcaster']['id'],
            'broadcaster_name' => $request['broadcaster']['name'],
            'broadcaster_display_name' => $request['broadcaster']['display_name'],
            'broadcaster_channel_url' => $request['broadcaster']['channel_url'],
            'broadcaster_logo' => $request['broadcaster']['logo'],

            'curator_id' => $request['curator']['id'],
            'curator_name' => $request['curator']['name'],
            'curator_display_name' => $request['curator']['display_name'],
            'curator_channel_url' => $request['curator']['channel_url'],
            'curator_logo' => $request['curator']['logo'],

            'vod_id' => $request['vod']['id'],
            'vod_url' => $request['vod']['url'],

            'thumbnails_small' => $request['thumbnails']['small'],
            'thumbnails_medium' => $request['thumbnails']['medium'],
            'thumbnails_tiny' => $request['thumbnails']['tiny']
        ];
    }
}

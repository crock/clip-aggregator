<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Clip extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Clip';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
		'id',
		'twitch_clip_id',
		'title',
		'custom_title',
		'broadcaster_name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
			ID::make()->sortable(),
			Text::make('Twitch Slug', 'twitch_clip_id'),
			Text::make('Broadcaster Name')->sortable(),
			Text::make('Creator Name')->sortable(),
			Text::make('Title')->sortable(),
			Text::make('Custom Title')->sortable(),
			Text::make('Broadcaster ID')->hideFromIndex(),
			Text::make('Creator ID')->hideFromIndex(),
			Text::make('Broadcaster ID')->hideFromIndex(),
			Text::make('Video ID')->hideFromIndex(),
			Text::make('Game ID')->hideFromIndex(),
			Text::make('Language')->sortable(),
			Number::make('View Count')->sortable(),
			Text::make('Clip Creation Date', 'clip_created_date')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}

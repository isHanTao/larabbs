<?php

namespace App\Nova;

use App\Nova\Filters\TopicType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Topic extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Topic::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $group = '内容管理';

    public static $searchRelations = [
        'user' => ['name', 'email'],'category'=>['name']
    ];

    public static function label()
    {
        return '话题';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','excerpt','title','body'
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
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('标题','title')->sortable(),
            Text::make('简介','excerpt')->onlyOnDetail(),
            BelongsTo::make('作者','user','App\Nova\User')->sortable(),
            BelongsTo::make('分类','category','App\Nova\Category')->sortable(),
            Text::make('回复数量','reply_count')->sortable()->exceptOnForms(),
            Trix::make('内容','body')
                ->withFiles('public', "/uploads/images/topics/" . date("Ym/d", time()).'/'),

            HasMany::make('replies'),
            Date::make('创作时间','created_at')->sortable()->exceptOnForms(),
            Text::make('操作','id', function ($id) {
                return "<a class='btn btn-primary btn-default' target='_blank' href='/topics/$id' style='font-size: 12px'>详情</a>";
            })->exceptOnForms()->asHtml(),
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

    public function subtitle()
    {
        return "Author: {$this->user->name}";
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new TopicType()];
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

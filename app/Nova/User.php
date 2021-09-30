<?php

namespace App\Nova;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Vyuldashev\NovaPermission\RoleSelect;


class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;


    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email','introduction'
    ];

    public static function label()
    {
        return '用户';
    }


    public static $with = ['roles'];


    public static $group = '角色及权限';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $uploader = new ImageUploadHandler();

        return [
            ID::make()->sortable(),
            Avatar::make('头像','avatar')->store(function (Request $request, $model) use ($uploader) {
                $result = $uploader->save($request->avatar, 'avatars', $model->id, 416);
                return [
                    'avatar' => $result['path'],
                ];
            }),

            Text::make('姓名','name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('邮箱','email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('注册时间','created_at',function ($time){
                return $time->format('Y-m-d H:i:s');
            })->exceptOnForms(),

            Text::make('角色','roles')->resolveUsing(function ($roles) {
                return implode(Arr::pluck($roles,'name'),',');
            })->exceptOnForms(),

            HasMany::make('话题','topics',Topic::class)->exceptOnForms(),

            Text::make('操作','id', function ($id) {
                return "<a class='btn btn-primary btn-default' target='_blank' href='/users/$id' style='font-size: 12px'>详情</a>";
            })->exceptOnForms()->asHtml(),


            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            RoleSelect::make('角色', 'roles')->onlyOnForms(),

            MorphToMany::make('角色', 'roles', \Vyuldashev\NovaPermission\Role::class)
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
        return [
            ID::make()->sortable(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new Filters\UserType];
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
        return [
//            (new Actions\ShowUserInfo)->onlyOnTableRow(),
//            (new Actions\EmailAccountProfile())->onlyOnTableRow()->standalone(),
        ];
    }
}

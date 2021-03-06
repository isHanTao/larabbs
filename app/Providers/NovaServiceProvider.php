<?php

namespace App\Providers;


use App\Models\User;
use App\Nova\Metrics\TopicCount;
use App\Nova\Metrics\UsersCount;
use App\Nova\Statistics\Statistic;
use App\Nova\Statistics\UserStatistic;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use OptimistDigital\NovaSettings\NovaSettings;


class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        \OptimistDigital\NovaSettings\NovaSettings::addSettingsFields([
            Text::make('站点名称', 'title')->updateRules([
                'required', 'max:20'
            ]),
            Text::make('联系邮箱', 'email')->updateRules([
                'required', 'email'
            ]),
            Textarea::make('SEO-description', 'seo_description')->updateRules([
                'required', 'max:255'
            ]),
            Textarea::make('SEO-keywords','seo_keywords')->updateRules([
                'required', 'max:255'
            ]),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function (User $user) {
            return $user->hasNovaPermission();
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
//            (new Analytics)->currentVisitors(),
            new UsersCount,
            Statistic::getUserStatistic(),
            new TopicCount,
            Statistic::getTopicStatistic(),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            \Vyuldashev\NovaPermission\NovaPermissionTool::make()->rolePolicy(RolePolicy::class)
                ->permissionPolicy(PermissionPolicy::class),
            NovaSettings::make()->canSee(function(){
                return Auth::user()->can('edit_settings');
            }),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function resources()
    {
        Nova::resourcesIn(app_path('Nova'));
    }
}

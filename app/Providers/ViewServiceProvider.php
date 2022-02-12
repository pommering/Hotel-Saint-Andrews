<?php

namespace App\Providers;

use App\Models\Tarefas;
use App\Models\User;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['clean_rooms.fields'], function ($view) {
            $activityItems = Tarefas::pluck('assignment','id')->toArray();
            $view->with('activityItems', $activityItems);
        });
        View::composer(['clean_rooms.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
        //
    }
}

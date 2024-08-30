<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
            $h_page = session()->get('h_page');

            if ($h_page == 'backend') {
                $Homepage = 'home-backend';
                $page_type = 'backend';
                $typeSreach = 'contract';
                $dataSreach = [
                    'namecus' => true,
                    'idcardcus' => true,
                    'license' => true,
                    'contract' => true,
                ];
            } else {
                $Homepage = 'home-frontend';
                $page_type = 'frontend';
                $typeSreach = 'namecus';
                $dataSreach = [
                    'namecus' => true,
                    'idcardcus' => true,
                    'license' => true,
                    'contract' => true,
                    'phone' => true,
                ];
            }

            $view->with(compact('Homepage', 'page_type', 'typeSreach', 'dataSreach'));
        });


        // view()->composer('*', function ($view) {
        //     $user = Auth::user();
        //     if (auth()->user()->hasAnyRole(['admin ', 'superadmin'])) {
        //         dd(auth()->user());
        //     }

        //     //...with this variable
        //     $view->with('user', $user);   
        // });

    }
}
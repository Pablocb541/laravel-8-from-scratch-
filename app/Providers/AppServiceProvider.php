<?php

namespace App\Providers;

use App\Services\Newsletter;
use App\Models\User;
use App\Services\MailchimpNewsletter;
use Facade\FlareClient\Api;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use MailchimpMarketing\ApiClient;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(Newsletter::class, function () {

            $client = (new ApiClient)->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us22'
            ]);


            return new MailchimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();

        Gate::define('admin', function (User $user) {
            return $user->username === 'Pablo123';
        });

        Blade::if('admin', function () {
            return request()->user()?->can('admin');
        });
    }
}
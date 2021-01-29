<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\Request;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            $user      = $request->input('user');
            $signature = $request->input('signature');

            if ($user && $signature) {
                $result = User::query()
                    ->where('name', $user)
                    ->where('signature', $signature)
                    ->first();

                if ($result) {
                    $result->last_login_at = Carbon::now();
                    $result->save();

                    return $result;
                }

                $model                = new User();
                $model->name          = $user;
                $model->signature     = $signature;
                $model->last_login_at = Carbon::now();
                $model->ip            = $request->ip();

                if ($model->save()) {
                    return $model;
                }
            }
        });
    }
}

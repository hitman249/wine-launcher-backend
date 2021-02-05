<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Image;
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
            $user   = $request->input('user');
            $hashes = $request->input('hashes');

            if ($user && $hashes) {
                $hashes = is_array($hashes) ? $hashes : json_decode($hashes, true);
                /** @var User $result */
                $result = User::query()
                    ->where('name', $user)
                    ->get()
                    ->first(function ($item) use ($hashes) {
                        $count  = count($item->hashes);
                        $result = count(array_diff($item->hashes, $hashes));

                        return $count !== $result;
                    });

                if ($result) {
                    if ($newHashes = array_diff($hashes, $result->hashes)) {
                        $result->hashes = array_unique(array_merge($result->hashes, $newHashes));
                    }

                    $result->last_login_at = Carbon::now();
                    $result->save();

                    return $result;
                }

                $model                = new User();
                $model->name          = $user;
                $model->hashes        = $hashes;
                $model->last_login_at = Carbon::now();

                if ($model->save()) {
                    return $model;
                }
            }
        });

        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        $config = [
            'config-update',
            'config-delete',
        ];

        foreach ($config as $ability) {
            Gate::define($ability, static function (User $user, Config $config = null) {
                if (!$config) {
                    return false;
                }

                if ($user->isAdmin()) {
                    return true;
                }

                return $user->id === $config->user_id;
            });
        }

        $like = [
            'like-config',
            'like-image',
        ];

        foreach ($like as $ability) {
            Gate::define($ability, static function (User $user, $item = null) {
                /** @var Config|Image $item */

                if (!$item) {
                    return false;
                }

                return $item->like()->where('likes.user_id', $user->id)->count() < 1;
            });
        }

        $unlike = [
            'unlike-config',
            'unlike-image',
        ];

        foreach ($unlike as $ability) {
            Gate::define($ability, static function (User $user, $item = null) {
                /** @var Config|Image $item */

                if (!$item) {
                    return false;
                }

                return (bool)$item->like()->where('likes.user_id', $user->id)->count();
            });
        }
    }
}

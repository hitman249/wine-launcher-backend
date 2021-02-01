<?php

namespace App\Providers;

use App\Models\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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

    public function boot()
    {
        $this->registerValidators();
    }

    public function registerValidators()
    {
        Validator::extend('game_config', function ($attribute, $value, $parameters) {
            $config = [];

            if (is_string($value)) {
                $config = json_decode($value, true);
            }

            if (!$config) {
                return false;
            }

            $checkEmpty = [
                'app.name',
                'app.exe',
                'app.path',
                'app.version',
                'app.icon_height',
            ];

            foreach ($checkEmpty as $key) {
                if (null === Arr::get($config, $key, null)) {
                    return false;
                }
            }

            $name = Arr::get($config, 'app.name');

            if (Config::query()->ofName($name)->count()) {
                return false;
            }

            return true;
        });
    }
}

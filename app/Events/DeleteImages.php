<?php

namespace App\Events;

use App\Models\Config;
use App\Models\Image;

class DeleteImages extends Event
{
    /**
     * Create a new event instance.
     *
     * @param Config $config
     * @throws \Exception
     */
    public function __construct(Config $config)
    {
        if ($config->background_id) {
            (new Image())->deleteById($config->background_id);
        }

        if ($config->icon_id) {
            (new Image())->deleteById($config->icon_id);
        }
    }
}

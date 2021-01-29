<?php

namespace App\Http\Middleware;

class ConvertStringBooleans extends TransformsRequest
{
    protected function transform($key, $value)
    {
        if ($value === 'true' || $value === 'TRUE' || $value === 'True') {
            return true;
        }

        if ($value === 'false' || $value === 'FALSE' || $value === 'False') {
            return false;
        }

        return $value;
    }
}

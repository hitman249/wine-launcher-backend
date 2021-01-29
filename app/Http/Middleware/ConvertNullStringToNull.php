<?php

namespace App\Http\Middleware;

class ConvertNullStringToNull extends TransformsRequest
{
    protected function transform($key, $value)
    {
        if ('null' === $value || 'undefined' === $value || 'Null' === $value || 'NULL' === $value || 'NaN' === $value) {
            return null;
        }

        return $value;
    }
}

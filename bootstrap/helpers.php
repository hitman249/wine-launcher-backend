<?php

if (!function_exists('prepare_name')) {
    /**
     * @param string $name
     * @return string[]
     */
    function prepare_name(string $name)
    {
        foreach ([':', '-', '=', ';', '$', '#', '@', '`', '.', '"', "'", '*', '(', ')', '[', ']', '<', '>', '^'] as $delimiter) {
            $name = str_replace($delimiter, '', $name);
        }

        foreach (['&', '+', '_', '|', '\\', '/', ','] as $delimiter) {
            $name = str_replace($delimiter, ' ', $name);
        }

        return array_filter(explode(' ', $name));
    }
}

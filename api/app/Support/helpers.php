<?php

if (! function_exists('pagination')) {
    /**
     * Retorna uma instância do builder de paginação.
     */
    function pagination($subject): App\Support\PaginationBuilder
    {
        return \App\Support\PaginationBuilder::for($subject);
    }
}

if (! function_exists('iso8601')) {
    function iso8601($date): ?string
    {
        if (! $date) {
            return null;
        }

        return (new \Carbon\Carbon($date))->toIso8601String();
    }
}

if (! function_exists('output_date_format')) {
    function output_date_format($date): ?string
    {
        return iso8601($date);
    }
}

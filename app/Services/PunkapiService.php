<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PunkapiService
{
    public function getBeers(array $params)
    {
        return Http::punkapi()
            ->get('/beers', $params)
            ->throw()
            ->json();
    }
}
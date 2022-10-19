<?php

namespace App\Http\Controllers;

use App\Exports\BeerExport;
use App\Http\Requests\IndexBeerRequest;
use App\Services\PunkapiService;
use Maatwebsite\Excel\Facades\Excel;

class BeerController extends Controller
{
    public function index(IndexBeerRequest $request, PunkapiService $service)
    {
        return $service->getBeers($request->validated());
    }

    public function export(IndexBeerRequest $request, PunkapiService $service)
    {
        $beers = $service->getBeers($request->validated());
        $filteredBeers = array_map(function ($beer) {
            return collect($beer)
                ->only(['name', 'tagline', 'first_brewed', 'description'])
                ->toArray();
        }, $beers);

        Excel::store(new BeerExport($filteredBeers), 'olw-report.xlsx');
    }
}

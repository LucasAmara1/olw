<?php

namespace App\Http\Controllers;

use App\Exports\BeerExport;
use App\Http\Requests\IndexBeerRequest;
use App\Jobs\ExportJob;
use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use App\Models\Meal;
use App\Services\PunkapiService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class BeerController extends Controller
{
    public function index(IndexBeerRequest $request, PunkapiService $service)
    {
        $filters = $request->validated();
        $beers = $service->getBeers($request->validated());
        $meals = Meal::all();

        return Inertia::render('Beers', [
            'beers' => $beers,
            'meals' => $meals,
            'filters' => $filters
        ]);
    }

    public function export(IndexBeerRequest $request, PunkapiService $service)
    {
        $filename = 'cervejas-' . now()->format('Y-m-d-H_i') . '.xlsx';

        ExportJob::withChain([
            new SendExportEmailJob($filename),
            new StoreExportDataJob(auth()->user(),$filename)
        ])->dispatch($request->validated(), $filename);

        return redirect()->back()
            ->with('success', 'Seu arquivo foi enviado para processamento e en breve estará em seu email.');
    }
}

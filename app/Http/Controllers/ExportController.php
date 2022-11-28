<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ExportController extends Controller
{
    public function index()
    {
        $exports = Export::paginate(20);

        return Inertia::render('Reports', [
            'exports' => $exports
        ]);
    }

    public function show($export)
    {
        $export = Export::find($export);

        return Storage::download($export->file_name);
    }

    public function destroy(int $export)
    {
        $export = Export::find($export);

        if ($export) {
            Storage::delete($export->file_name);
            $export->delete();
        }

        return redirect()->back()
            ->with('success', 'Seu arquivo foi removido com sucesso.');
    }
}
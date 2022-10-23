<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function index()
    {
        return Export::paginate(20);
    }

    public function destroy(Export $export)
    {
        Storage::delete($export->filename);
        $export->delete();

        return 'deletou';
    }
}
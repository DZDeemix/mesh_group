<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRowRequest;
use App\Http\Requests\UpdateRowRequest;
use App\Models\Row;
use App\Services\ExcelParserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RowController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $rows = Row::query()->selectRaw('date, GROUP_CONCAT(name) AS name')
            ->groupBy('date')
            ->paginate(10);

        return view('rows.index', compact('rows'));
    }

}

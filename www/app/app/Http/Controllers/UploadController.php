<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Http\Requests\UploadFileRequest;
use App\Imports\RowsImport;
use App\Jobs\ParseExcelFile;
use App\Models\Row;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function show(): \Illuminate\Contracts\View\View
    {
        return view('file.upload');
    }

    public function uploadFile(UploadFileRequest $request): JsonResponse
    {
        try {
            $file = $request->file('excel_file');
            $path = $file->store('excel_files');

            Excel::queueImport(new RowsImport(), $path);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'error']);
        }

    }
}

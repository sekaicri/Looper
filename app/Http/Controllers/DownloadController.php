<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    public function downloadCodes(Request $request)
    {
        $codes = explode(',', $request->input('codes'));

        $content = implode(PHP_EOL, $codes);

        $response = Response::make($content);

        $response->header('Content-Type', 'text/plain');

        $response->header('Content-Disposition', 'attachment; filename="codes.txt"');

        return $response;
    }
}
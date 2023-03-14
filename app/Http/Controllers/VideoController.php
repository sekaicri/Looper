<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Request $request)
    {
        return view('show', ['id' => $request->id]);
    }
}
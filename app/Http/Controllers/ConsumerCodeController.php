<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eventscodes;
use App\Models\ConsumerCode;

class ConsumerCodeController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'code' => 'required',
    ]);

    $code = $request->input('code');

    if ($code === null) {
        return response()->json([
            'error' => 'El campo code no puede estar vacío.',
        ], 400);
    }

    $eventCode = eventscodes::where('code', $code)->first();
    if (!$eventCode) {
        return response()->json([
            'message' => 'El código de evento no existe.',
            'exists' => false,
        ]);
    }

    $existingConsumerCode = ConsumerCode::where('code', $code)->first();
    if ($existingConsumerCode) {
        return response()->json([
            'message' => 'El código ya esta en uso',
        ]);
    }

    // Crear el nuevo registro en ConsumerCode
    ConsumerCode::create([
        'code' => $code,
    ]);

    return response()->json([
        'message' => 'El registro se ha creado correctamente.',
        'event_id' => $eventCode->event_id,
    ]);
}
}

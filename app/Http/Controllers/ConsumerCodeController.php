<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eventscodes;
use App\Models\ConsumerCode;
use App\Models\Video;

use Illuminate\Support\Facades\Validator;


class ConsumerCodeController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'code' => [
            'required',
            'present',
            function ($attribute, $value, $fail) {
                if (empty($value)) {
                    return response()->json([
                        'message' => 'El código de evento no existe.',
                    ],400); }
            },
        ],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors()->first('code'),
        ], 400);
    }

    $code = $request->input('code');

    $eventCode = eventscodes::where('code', $code)->first();

    if (!$eventCode) {
        return response()->json([
            'message' => 'El código de evento no existe.',
        ],400);
    }

    $existingConsumerCode = ConsumerCode::where('code', $code)->first();
    if ($existingConsumerCode) {
        return response()->json([
            'message' => 'El código ya esta en uso',
        ],400);
    }

    // Crear el nuevo registro en ConsumerCode
    ConsumerCode::create([
        'code' => $code,
    ]);

    return response()->json([
        'message' => 'El registro se ha creado correctamente.',
        'event_id' => $eventCode->event_id,
    ],200);
}
}

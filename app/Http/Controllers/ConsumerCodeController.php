<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\eventscodes;
use App\Models\ConsumerCode;
use App\Models\Video;
use Carbon\Carbon;
use App\Models\Events;

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
                        ], 400);
                    }
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
            ], 400);
        }
    
        $existingConsumerCode = ConsumerCode::where('code', $code)->first();
        if ($existingConsumerCode) {
            return response()->json([
                'message' => 'El código ya está en uso',
            ], 400);
        }
    
        $currentDate = Carbon::now()->format('Y-m-d');
        $totalConsumerCodes = ConsumerCode::whereDate('created_at', $currentDate)->count();
        $counter = floor($totalConsumerCodes / 30);
    
        // Crear el nuevo registro en ConsumerCode
        ConsumerCode::create([
            'code' => $code,
        ]);
    
        $event = Events::find($eventCode->event_id);
        $event->save();
        $eventCode->event_id .= $counter;
    
        return response()->json([
            'message' => 'El registro se ha creado correctamente.',
            'event_id' => $eventCode->event_id,
            'event_url' => $event->url,
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function show(Request $request)
    {
        return view('show', ['id' => $request->id]);
    }

    public function saveString(Request $request)
    {
        $user = Video::create([
            'url' => $request['url'],
            'event_id' => $request['event_id'],
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      => $user
        ]);
    }

    
    public function update(Request $request)
    {
        if ($request->has('event_id')) {
            $creation = Video::find($request->id);

            if ($creation) {
                $creation->update($request->all());
                return response()->json([
                    'success'   => true,
                    'message'   => 'Actualizacion Correcta',
                    'data'      => $creation
                ]);
            }
        }
        return response()->json([
            'success'   => false,
            'message'   => 'No coincide con nada',
            'data'      => null
        ]);
    }


    public function search(Request $request)
    {
        if ($request->has('event_id')) {
            $creation = Video::find($request->event_id);

            if ($creation) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Tiene video',
                    'data'      => $creation
                ]);
            } 
        }
        return response()->json([
            'success'   => false,
            'message'   => 'No coincide con nada',
            'data'      => null
        ]);
    }
    
}
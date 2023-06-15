<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsRequest;
use App\Models\Events;
use App\Models\eventscodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EventsController extends Controller
{
    public function index()
    {
        //
    }

    public function createEvent(EventsRequest $request)
    {
        $code = $this->generateUniqueCode();
        $data = [
            'name' => $request->name,
            'fecha' => $request->fecha,
            'code' => $code,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'url' => $request->url
        ];

        if ($request->user_id === null) {
            unset($data['user_id']);
        }

        $event = Events::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Registro exitoso',
            'data' => $event
        ]);
    }

    public function generateUniqueCode()
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 8;

        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        if (Events::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }

    public function generateCodes()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 10;

        $code = '';


        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        if (eventscodes::where('code', $code)->exists()) {
            $this->generateCodes();
        }

        return $code;
    }

    public function CreatedCodes(Request $request)
    {
        for ($i = 0; $i < $request['num']; $i++) {
            $code = $this->generateCodes();
            $events = eventscodes::create([
                'event_id' => $request['event_id'],
                'code' => $code,
            ]);
        }
        $nameEvent = Events::where('id', $request->event_id)->first();
        // $nameEvent = Events::find($request->event_id);
        $creation = DB::SELECT('(SELECT * FROM eventscodes al where event_id = ' . $request->event_id . ')');

        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'event'   =>  $nameEvent,
            'data'      => $creation
        ]);
    }
    public function showEventCodes(Request $request)
    {
        $code = $request->input('code');

        $eventCode = eventscodes::where('code', $code)->first();

        if ($eventCode) {
            $event = Events::find($eventCode->event_id);

            return response()->json([
                'success' => true,
                'message' => 'Evento encontrado',
                'event' => $event
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Código inválido'
            ]);
        }
    }

    public function show()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $events = DB::table('events')->where('fecha', '>', $fechaActual)->get();

        return response()->json([
            'success' => true,
            'message' => 'Registro exitoso',
            'data' => $events
        ]);
    }

    public function showCode(Request $request)
    {
        $creation = DB::SELECT('(SELECT * FROM eventscodes al where event_id = ' . $request->event_id . ')');
        return response()->json([
            'success'   => true,
            'message'   => 'Estos son los codigos vinculados',
            'data'      => $creation
        ]);
    }


    public function updateUrl(Request $request)
    {
        $eventId = $request->input('id');
        $eventName = $request->input('name');

        if ($eventId !== null) {
            $event = Events::find($eventId);
            if ($event) {
                $event->url = $request->input('url');
                $event->save();
                return response()->json([
                    'success' => true,
                    'message' => 'URL actualizada exitosamente',
                    'data' => $event
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el evento con el ID proporcionado'
                ], 404);
            }
        } elseif ($eventName !== null) {
            $event = Events::where('name', $eventName)->first();
            if ($event) {
                $event->url = $request->input('url');
                $event->save();
                return response()->json([
                    'success' => true,
                    'message' => 'URL actualizada exitosamente',
                    'data' => $event
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el evento con el nombre proporcionado'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se proporcionó ni el ID ni el nombre del evento'
            ], 400);
        }
    }


    public function destroy($id)
    {
        //
    }
}

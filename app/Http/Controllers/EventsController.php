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


    public function CreateEvent(EventsRequest $request)
    {
        $code = $this->generateUniqueCode();
        $user = $request->user_id;
        $description = $request->description;

        if ($user != null) {

            $events = Events::create([
                'name' => $request['name'],
                'fecha' => $request['fecha'],
                'code' => $code,
                'user_id' => $user,
                'description' => $description,

            ]);
        } else {
            $events = Events::create([
                'name' => $request['name'],
                'fecha' => $request['fecha'],
                'code' => $code,
            ]);
        }


        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      => $events
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
        $user = eventscodes::where('code', $request['code'])->first();
        if ($user) {
            $nameEvent = Events::where('id', $user->event_id)->first();
            return response()->json([
                'success'   => true,
                'message'   => 'Evento',
                'event'   =>  $nameEvent,
            ]);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'Codigo Invalido',
            ]);
        }
    }
    public function show()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $users = DB::table('events')->whereDate('fecha', '>=', $fechaActual)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      => $users
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


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}

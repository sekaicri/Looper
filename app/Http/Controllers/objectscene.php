<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\clothesRequest;
use App\Models\objectsScene;
use App\Models\objectsSceneEvent;
use Illuminate\Support\Facades\DB;

class objectscene extends Controller
{

    public function index()
    {
        //
    }

  
    public function create(clothesRequest $request)
    {
        $events = objectsScene::create([
            'name' => $request['name'],
        ]);

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
        $codeLength = 5;

        $code = '';

        while (strlen($code) < $codeLength) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        if (objectsSceneEvent::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }

    public function CreatedCodeclothes(Request $request)
    {
        $mynames = collect([]);

        for ($i = 0; $i < $request['num']; $i++) {
            $code = $this->generateUniqueCode();
            $events = objectsSceneEvent::create([
                'objects_scenes_id' => $request['objects_scenes_id'],
                'code' => $code,
            ]);
            $mynames->push($events);
        }
        

        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      =>  $mynames
        ]);
    }

    public function buyClothes(Request $request)
    {
        $user = objectsSceneEvent::where('code',$request['code'])->first();
        if($user->buy !=1){
            $user->events_id = $request->events_id;
            $user->buy = 1;
            $user->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Compra Realizada con exito',
            ]);
        }
        else{
            return response()->json([
                'success'   => false,
                'message'   => 'Ya esta en uso, o el codigo no es valido',
                'data'      => null
            ]);

        }
    }

  
    public function show(Request $request)
    {
        $creation = DB::SELECT('(SELECT * FROM objectsSceneEvent al where events_id = ' . $request->events_id . ')');
        return response()->json([
            'success'   => true,
            'message'   => 'estos son los codigos',
            'data'      => $creation 
        ]);
    }

   
    public function showClothes()
    {
        $creation = DB::SELECT('(SELECT * FROM objectsScene )');
        return response()->json([
            'success'   => true,
            'message'   => 'Lista de Objectos',
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

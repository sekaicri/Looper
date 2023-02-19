<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\clothesRequest;
use App\Models\objectsScene;
use App\Models\objectsSceneEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;


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
            'imagen' => $request['imagen']
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
        $creation = DB::SELECT('(SELECT * FROM objects_scene_events al where objects_scenes_id = ' . $request->objects_scenes_id . ')');
        return response()->json([
            'success'   => true,
            'message'   => 'estos son los codigos',
            'data'      => $creation 
        ]);
    }

    public function showObjects(Request $request)
    {
        $creation = DB::SELECT('(SELECT * FROM objects_scene_events al where events_id = ' . $request->events_id . ')');
        return response()->json([
            'success'   => true,
            'message'   => 'estos son los objectos de la escena',
            'data'      => $creation 
        ]);
    }


   
    public function showClothes()
    {
        $creation = DB::SELECT('(SELECT * FROM objects_scenes )');
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

    public function registerImagen(Request $request)
    {
        try {
            $filename = "";
            if ($request->hasFile('imagen')) {
                $uniqid = uniqid();
                $file = $request->file('imagen');
                $filename = $uniqid . '.' . $file->getClientOriginalExtension();
                $file->storeAs($request->project_id, $filename, 'public');
                // $filename = $request->file('imagen')->store('posts','public');
            } else {
                $filename = Null;
            }
            $filename = 'http://45.132.240.186/storage/'.$filename;
            // inicio de transaccion
            DB::beginTransaction();

            // confirmar transaccion
            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Registro exitoso',
                'link'      => $filename
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error En La Generación De La Solicitud'
            ], 500, [], JSON_PRETTY_PRINT);
        }
    }




}

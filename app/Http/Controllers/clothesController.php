<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\clothesRequest;
use App\Models\clothes;
use App\Models\clothesuser;
use Illuminate\Support\Facades\DB;

class clothesController extends Controller
{
   
    public function index()
    {
        //
    }

  
    public function create(clothesRequest $request)
    {
        $events = clothes::create([
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

        if (clothesuser::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }

    public function CreatedCodeclothes(Request $request)
    {
        $mynames = collect([]);

        for ($i = 0; $i < $request['num']; $i++) {
            $code = $this->generateUniqueCode();
            $events = clothesuser::create([
                'clothes_id' => $request['clothes_id'],
                'code' => $code,
            ]);
            $mynames->push($events);
        }
        // $nameEvent = Events::find($request->event_id);
        //$creation = DB::SELECT('(SELECT * FROM clothesusers al where clothes_id = ' . $request->clothes_id . ')');

        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      =>  $mynames
        ]);
    }

    public function buyClothes(Request $request)
    {
        $user = clothesuser::where('code',$request['code'])->first();
        if($user->buy !=1){
            $user->user_id = $request->user_id;
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
        $creation = DB::SELECT('(SELECT * FROM clothesusers al where clothes_id = ' . $request->clothes_id . ')');
        return response()->json([
            'success'   => true,
            'message'   => 'estos son los codigos',
            'data'      => $creation 
        ]);
    }

   
    public function showClothes()
    {
        $creation = DB::SELECT('(SELECT * FROM clothes )');
        return response()->json([
            'success'   => true,
            'message'   => 'Lista de Ropa',
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

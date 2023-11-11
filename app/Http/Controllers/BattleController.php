<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Battle;

class BattleController extends Controller
{
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

        if (Battle::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }

    public function generateUniqueCodes(Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $value = $request->input('value', 5);
    
        $codes = [];
    
        for ($i = 0; $i < $quantity; $i++) {
            $code = $this->generateUniqueCode();
            
            $battleUser = Battle::create([
                'value' => $value,
                'code' => $code,
                'paid' => false,
                'used' => false,
            ]);
    
            $codes[] = $code;
        }
    
        return response()->json([
            'data' => $codes,
        ]);
    }

public function markCodeAsUsed(Request $request)
{
    $code = $request->input('code');

    $battleUser = Battle::where('code', $code)->first();

    if ($battleUser && !$battleUser->used) {
        $battleUser->used = true;
        $battleUser->save();

        return response()->json([
            'success' => true,
            'message' => 'Code marked as used successfully',
            'data' => $battleUser,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Code not found or already used',
            'data' => null,
        ], 404);
    }
}

public function markCodeAsPaid(Request $request)
{
    $code = $request->input('code');

    // Buscar el código en la base de datos
    $battleUser = Battle::where('code', $code)->first();

    // Verificar si el código existe
    if ($battleUser) {
        // Verificar si el código ya ha sido pagado
        if ($battleUser->paid) {
            return response()->json([
                'success' => false,
                'message' => 'Code has already been paid',
                'data' => null,
            ]);
        }

        // Marcar el código como pagado
        $battleUser->paid = true;
        $battleUser->save();

        return response()->json([
            'success' => true,
            'message' => 'Code marked as paid successfully',
            'data' => $battleUser,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Code not found',
            'data' => null,
        ], 404);
    }
}
}

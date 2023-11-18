<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Battle;
use App\Models\Games;

class BattleController extends Controller
{

    public function generateUniqueCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 4;

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
        $value = $request->input('value');
    
        $battleUser = Battle::where('code', $code)
            ->when($value, function ($query) use ($value) {
                return $query->where('value', $value);
            })
            ->where('used', false)
            ->first();
    
        if ($battleUser) {
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
                'message' => 'Code not found, already used, or mismatched value',
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

public function isCodePaid(Request $request)
{
    $code = $request->input('code');

    // Buscar el código en la base de datos
    $battleUser = Battle::where('code', $code)->first();

    // Verificar si el código existe y ha sido pagado
    $isPaid = $battleUser ? $battleUser->paid : false;

    return response()->json([
        'isPaid' => $isPaid,
    ]);
}
public function showGenerateCodesForm()
{
    $tournamentRecords = $this->getTournamentRecords();

    return view('generate_codes_form', ['codes' => [], 'tournamentRecords' => $tournamentRecords]);
}

public function generateCodes(Request $request)
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

    $tournamentRecords = $this->getTournamentRecords();

    return view('generate_codes_form', ['codes' => $codes, 'tournamentRecords' => $tournamentRecords]);
}

public function isCode($code)
{
        $response = $this->isCodePaid(new Request(['code' => $code]));
        $responseData = json_decode($response->getContent(), true);
        return isset($responseData['isPaid']) ? $responseData['isPaid'] : false;
    
}

private function getTournamentRecords()
{
    $nameGame = 'Battle'; // Asumimos que el nombre del juego es "Battle"

    $gameRecords = Games::where('name_game', $nameGame)->get();

    $tournamentRecords = $gameRecords->map(function ($record) {
        $description = null;
        if ($record->description) {
            $description = json_decode($record->description);
        }

        $isCodePaid = $this->isCode($record->code);

        return [
            'name_user' => $record->name_user,
            'score' => $record->score,
            'description' => $description,
            'is_code_paid' => $isCodePaid,
            'code' => $record->code,
        ];
    });

    return $tournamentRecords;
}

}

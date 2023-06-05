<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Games;
use App\Models\User;

class GameController extends Controller
{
    public function store(Request $request)
    {
        // Verificar si los campos son nulos
        if ($request->user_id === null || $request->name === null || $request->score === null) {
            return response()->json(['error' => 'Los campos no pueden ser nulos'], 400);
        }
    
        $validatedData = $request->validate([
            'name_user' => 'required',
            'name_game' => 'required',
            'score' => 'required',
        ]);
    
        $game = Games::where('name_game', $validatedData['name_game'])
            ->where('name_user', $validatedData['name_user'])
            ->first();
    
        if ($game) {
            if ($validatedData['score'] > $game->score) {
                $game->score = $validatedData['score'];
                $game->save();
            }
        } else {
            $game = new Games();
            $game->name_user = $validatedData['name_user'];
            $game->name_game = $validatedData['name_game'];
            $game->score = $validatedData['score'];
            $game->save();
        }
    
        return response()->json(['message' => 'Juego registrado/actualizado con éxito'], 200);
    }


    public function getTopScores(Request $request)
    {
        $topScores = Games::select('score', 'name_user')
        ->where('name_game', $request['name_game'])
        ->orderBy('score', 'desc')
        ->take(10)
        ->get();

    $result = $topScores->map(function ($score) {
        return [
            'score' => $score->score,
            'user_id' => $score->name_user,
        ];
    });

    return response()->json(['message' => 'Juego registrado/actualizado con éxito', 'top_scores' => $result], 200);
    }
}

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
        $validatedData = $request->validate([
            'name_user' => 'required',
            'name_game' => 'required',
            'score' => 'required',
            'description' => 'nullable', // Campo description ahora es opcional
        ]);
    
        $game = Games::where('name_game', $validatedData['name_game'])
            ->where('name_user', $validatedData['name_user'])
            ->first();
    
        if ($game) {
            if ($validatedData['score'] > $game->score) {
                $game->score = $validatedData['score'];
                $game->description = $validatedData['description']; // Actualizar description si se proporciona
                $game->save();
            }
        } else {
            $game = new Games();
            $game->name_user = $validatedData['name_user'];
            $game->name_game = $validatedData['name_game'];
            $game->score = $validatedData['score'];
            $game->description = $validatedData['description']; // Asignar description si se proporciona
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
            'name_user' => $score->name_user,
        ];
    });

    return response()->json([ 'top_scores' => $result], 200);
    }
    public function getScoresByUserName(Request $request)
    {
        $userName = $request['name_user'];
    
        $userScores = Games::select('score', 'name_user', 'description') // Include 'description' column
            ->where('name_game', $request['name_game'])
            ->where('name_user', $userName)
            ->orderBy('score', 'desc')
            ->get();
    
        $result = $userScores->map(function ($score) {
            return [
                'score' => $score->score,
                'name_user' => $score->name_user,
                'description' => $score->description, // Include 'description' in the response
            ];
        });
    
        return response()->json($result);
    }
}

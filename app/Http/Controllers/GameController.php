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
            'user_id' => 'required|integer',
            'name' => 'required',
            'score' => 'required',
        ]);
    
        $game = Games::where('name', $validatedData['name'])
            ->where('user_id', $validatedData['user_id'])
            ->first();
    
        if ($game) {
            if ($validatedData['score'] > $game->score) {
                $game->score = $validatedData['score'];
                $game->save();
            }
        } else {
            $game = new Games();
            $game->user_id = $validatedData['user_id'];
            $game->name = $validatedData['name'];
            $game->score = $validatedData['score'];
            $game->save();
        }
    
        return response()->json(['message' => 'Juego registrado/actualizado con éxito'], 200);
    }


    public function getTopScores(Request $request)
    {
        $name = $request->input('name');

        $topScores = Games::select('score', 'user_id')
            ->where('name', $name)
            ->orderBy('score', 'desc')
            ->take(10)
            ->get();

        $userIds = $topScores->pluck('user_id');

        $userNames = User::whereIn('id', $userIds)->pluck('name');

        $result = $topScores->map(function ($score) use ($userNames) {
            $userName = $userNames->get($score->user_id);
            return [
                'score' => $score->score,
                'user_id' => $score->user_id,
                'user_name' => $userName,
            ];
        });

        return response()->json(['top_scores' => $result], 200);
    }
}

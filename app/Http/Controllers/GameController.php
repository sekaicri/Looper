<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Games;
use App\Http\Controllers\BattleController;

class GameController extends Controller
{
    protected $battleController;

    public function __construct(BattleController $battleController)
    {
        $this->battleController = $battleController;
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name_user' => 'required',
        'name_game' => 'required',
        'score' => 'required',
        'description' => 'nullable', 
    ]);

    if ($validatedData['name_game'] !== 'Battle') {
        $game = Games::where('name_game', $validatedData['name_game'])
            ->where('name_user', $validatedData['name_user'])
            ->first();

        if ($game) {
            if ($validatedData['score'] > $game->score) {
                $game->score = $validatedData['score'];
                $game->description = $validatedData['description'];
                $game->save();
            }
        } else {
            $game = new Games();
            $game->name_user = $validatedData['name_user'];
            $game->name_game = $validatedData['name_game'];
            $game->score = $validatedData['score'];
            $game->description = $validatedData['description']; 
            $game->save();
        }
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

    public function getGameRecordsByName(Request $request)
    {
        $nameGame = $request->input('name_game');

        if (!$nameGame) {
            return response()->json(['error' => 'El parámetro name_game es obligatorio.'], 400);
        }

        $gameRecords = Games::where('name_game', $nameGame)->get();

        $result = $gameRecords->map(function ($record) {
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

        return response()->json(['game_records' => $result], 200);
    }

    public function isCode($code)
    {
        try {
            $response = $this->battleController->isCodePaid(new Request(['code' => $code]));
            $responseData = json_decode($response->getContent(), true);
            return isset($responseData['isPaid']) ? $responseData['isPaid'] : false;
        } catch (\Exception $e) {
            return false;
        }
    }
}

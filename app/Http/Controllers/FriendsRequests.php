<?php

namespace App\Http\Controllers;
use App\Models\relations;

use Illuminate\Http\Request;

class FriendsRequests extends Controller
{
    public function Register(Request $request)
    {
        $user = relations::create([
            'me' => $request->me,
            'other' => $request->other,
        ]);

    
        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      => $user
        ]);
    }
}

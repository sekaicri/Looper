<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RequestLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Constraint\IsFalse;

class AuthController extends Controller
{
    public function Register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'nftIdentify' => $request['nftIdentify'],
            'avatar' => $request['avatar'],
            'password' => bcrypt($request['password'])
        ]);

    
        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      => $user
        ]);
    }
    public function Members()
    {
            $creation = DB::SELECT('(SELECT * FROM users)');
                return response()->json([
                    'success'   => true,
                    'message'   => 'Miembros',
                    'data'      =>  $creation
                ]);
    }

    public function Friends(User $user){

    $bool = "true";
    $creation = DB::SELECT('(SELECT * FROM relations al where me = '. $user->id .' or other = '. $user->id .' and friends = '.$bool.')');
        return response()->json([
            'success'   => true,
            'message'   => 'Amigos',
            'data'      => $creation
        ]);
            
    }

    public function Requests(User $user)
    {
        $users = [];
        $bool = "false";
        $creation = DB::SELECT('(SELECT * FROM relations al where me = '. $user->id .' or other = '. $user->id .' and friends = '.$bool.')');
       /*foreach($creation as $s){
        array_push($users,$s);
       }*/
        return response()->json([
                'success'   => true,
                'message'   => 'Requests',
                'data'      => $creation
            ]);
    }
    
    public function Login(RequestLogin $request)
    {

     $user = User::where('email',$request['email'])->first();
     if(!$user||!Hash::check($request['password'], $user->password)){
        return response()->json([
            'success'   => true,
            'message'   => 'Los datos son incorrectos',
            'data'      => null
        ]);
     }

     /* $holi = $this-> Friends($user); 
     $holi1 = $this-> Requests($user); */

   $creation = DB::SELECT('(SELECT * FROM clothesusers al where user_id = ' .  $user->id . ')');
   $rooms = DB::SELECT('(SELECT * FROM events al where user_id = ' .  $user->id . ')');

        return response()->json([
            'success'   => true,
            'message'   => 'Login exitoso',
            'user'      => $user,
            'clothes' =>$creation,
            'rooms' =>$rooms,

            /*  'friends'    => $holi,
            'requests'=> $holi1*/

        ]);
    }

 
    public function update(Request $request)
    {
        if ($request->has('id')) {
            $creation = user::find($request->id);

            if ($creation) {
                $creation->update($request->all());
                return response()->json([
                    'success'   => true,
                    'message'   => 'Actualizacion Correcta',
                    'data'      => $creation
                ]);
            }
        }
        return response()->json([
            'success'   => false,
            'message'   => 'No coincide con nada',
            'data'      => null
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        //Validation
        $validator = Validator::make(
            $request->all(),
            [ //Reglas
                'country' => 'required',
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'user' => 'required|max:255|min:4|unique:users',
                'password' => 'required|min:8',
                'phone' => 'required|min:7'
            ],
            [ //Mensajes
                "country.required" => "Debe Selecionar Codigo De Pais",
                "name.required" => "Nombre es Requerido",
                "phone.required" => "Telefono es Requerido",
                "user.required" => trans("api.error.31"),
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()->all()
            ], 422);
        }


 

        $user = new User;
        $user->name           =   $request->name;
        $user->email          =   $request->email;
        $user->user           =   'hp-'.$request->user;
        $user->password       =   bcrypt($request->password);
        $user->phone          =   $request->phone;
        $user->role_id        =   2;
        $user->country        =   $request->country;
        $user->save();

        /*
        $verification_code = mt_rand(1000, 9999); //Generate verification code
        DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verification_code]);

        $name = $request->name;
        $email = $request->email;

        $subject = "Verifique su dirección de correo electrónico";
        Mail::send(
            'emails.verify',
            ['name' => $name, 'user' => $user->user, 'verification_code' => $verification_code],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
                $mail->to($email, $name);
                $mail->subject($subject);
            }
        ); */

        return response()->json(compact('user'), 201);
    }

    /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(Request $request)
    {
        $verification_code = $request->code;
        $check = DB::table('user_verifications')->where('token', $verification_code)->first();
        if ($check) {

            $user = User::find($check->user_id);

            if ($user->is_verified == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cuenta ya verificada .'
                ]);
            }

            $user->is_verified = 1;
            $user->save();
            DB::table('user_verifications')->where('token', $verification_code)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ha verificado correctamente su dirección de correo electrónico.'
            ]);
        }

        return response()->json(['success' => false, 'error' => "El código de verificación no es válido."]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 402);
        $user = $request->user();

        if (!$user->status) {
            return response()->json([
                'message' => 'Usuario Suspendido'
            ], 402);
        }

        //consultar saldo
        $available = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
            ->select(
                DB::raw('SUM(balance_general.monto) as available')
            )
            ->groupBy('balance_general.user_id')
            ->groupBy('users.user', 'users.id')
            ->find($user->id);
        $user->available = $available->available ? $available->available : 0;


        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->tokens->each(function ($token, $key){
            $token->delete();
        });
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user()
    {
        $user = auth()->user();
        /* Verificar si el usuario tiene poso */
        if ($user) {
            $available = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
                ->select(
                    DB::raw('SUM(balance_general.monto) as available')
                )
                ->groupBy('balance_general.user_id')
                ->groupBy('users.user', 'users.id')
                ->find($user->id);
            $user->available = $available->available ? $available->available : 0;
        }

        return response()->json($user);
    }

    public function unauthorized()
    {
        return view('unauthorized');
    }

    /**
     * API Verify User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            $newPassword = mt_rand(10000000, 99999999); //Generate verification code
            $user->password = bcrypt($newPassword);
            $name = $user->name;
            $email = $user->email;
            $user->save();

            $subject = "Recuperar contraseña";
            Mail::send(
                'emails.reset',
                ['name' => $name, 'user' => $user->user, 'newPassword' => $newPassword],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
                    $mail->to($email, $name);
                    $mail->subject($subject);
                }
            );
            return response()->json(['success' => true, 'message' => "Contraseña enviada a su correo electronico."]);
        }

        return response()->json(['success' => false, 'message' => "Direccion de correo invalida."], 401);
    }

    /**
     * updateUsers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUsers(Request $request)
    {
        //Validation
        $validator = Validator::make(
            $request->all(),
            [ //Reglas
                'country' => 'required',
                'name' => 'required|max:255',
                'password' => 'required|min:8',
                'phone' => 'required|min:10'
            ],
            [ //Mensajes
                "country.required" => "Debe Selecionar Codigo De Pais",
                "name.required" => "Nombre es Requerido",
                "phone.required" => "Telefono es Requerido",
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $user = auth()->user();

        $user = User::where('email', $user ->email)->first();

        $user->name           =   $request->name;
       
        $user->password       =   bcrypt($request->password);
        $user->phone          =   $request->phone;
        $user->country        =   $request->country;
        $user->save();

        /*
        $verification_code = mt_rand(1000, 9999); //Generate verification code
        DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verification_code]);

        $name = $request->name;
        $email = $request->email;

        $subject = "Verifique su dirección de correo electrónico";
        Mail::send(
            'emails.verify',
            ['name' => $name, 'user' => $user->user, 'verification_code' => $verification_code],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
                $mail->to($email, $name);
                $mail->subject($subject);
            }
        ); */

        return response()->json(compact('user'), 201);
    }
}

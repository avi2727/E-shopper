<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required|email",
            "password" => "required|string",
        ]);

        $token = $request->input("token"); // Token sent from the frontend for auto sign-in

        if ($token) {
            // Auto sign-in logic
            $user = User::where("remember_token", $token)->first();

            if ($user) {
                Auth::login($user);
               // $request->session()->put('userId', $user->id);
                return response()->json([
                    "code" => 1,
                    "message" => "Auto sign-in successful",
                    "userName" => $user->name,
                ]);
            } else {
                return response()->json([
                    "code" => 2,
                    "message" => "Auto sign-in error: Invalid token",
                ]);
            }
        } else {
            // Regular login logic
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
               // dd($user);
                $sessionId = session()->getId();
                $user->remember_token = $sessionId;
                $user->isloggedin = true;
                $user->save();

                return response()->json([
                    "code" => 1,
                    "message" => "Logged in successfully!",
                    "userName" => $user->name,
                    "userID" => $user->id,
                    "userEmail" => $user->email,
                    "usertoken" => $user->remember_token,
                    "isloggedin" => true,
                ]);
            } else {
                return response()->json([
                    "code" => 2,
                    "message" => "Login error: Invalid credentials.",
                ]);
            }
        }
    }
    public function autoSignIn(Request $request, $token)
    {
        $user = User::where("remember_token", $token)->first();
        if ($user) {
            Auth::login($user);
            return response()->json([
                "code" => 1,
                "message" => "Auto sign-in successful",
                "userName" => $user->name,
            ]);
        } else {
            return response()->json([
                "code" => 2,
                "message" => "Auto sign-in error: Invalid token",
            ]);
        }
    }

    public function logout(Request $request)
    {
        //dd($request->session()->all());
        Auth::logout();

        return response()->json([
            "code" => 1,
            "message" => "Logged out successfully!",
        ]);
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\login  $login
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6",
            "userName" => "required|string",
        ]);
        $user = User::create([
            "email" => $credentials["email"],
            "password" => Hash::make($credentials["password"]),
            "name" => $credentials["userName"],
        ]);

        if (!empty($user)) {
            if (
                Auth::attempt([
                    "email" => $credentials["email"],
                    "password" => $credentials["password"],
                ])
            ) {
                $user = Auth::user();
                $remember_token = session()->getId();
                $user->remember_token = $remember_token;
                $user->save();
                return response()->json([
                    "code" => 1,
                    "message" => "Logged in successfully!",
                    "userName" => $user->name,
                    "userID" => $user->id,
                    "userEmail" => $user->email,
                    "usertoken" => $user->remember_token,
                    "isloggedin" => true,
                ]);
            } else {
                $json["code"] = 2;
                $json["message"] = "Error While Logging!";
            }
        } else {
            $json["code"] = 3;
            $json["message"] = "Error While Registering!";
        }

        return response()->json($json);
    }
}

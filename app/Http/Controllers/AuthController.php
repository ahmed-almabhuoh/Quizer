<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //

    public function showLogin($guard)
    {
        return response()->view('cms.auth.login', [
            'guard' => $guard,
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|string|exists:' . $request->get('_guard') . 's',
            'password' => 'required|string',
            'remember' => 'required|boolean',
        ], [
            'email.exists' => 'Invalid email or password',
        ]);

        if (!$validator->fails()) {
            $creditionals = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            if (Auth::guard($request->get('_guard'))->attempt($creditionals, $request->get('remember'))) {
                return response()->json([
                    'message' => 'Login successfully',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Invalid email or password',
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout (Request $request) {
        if (auth('teacher')->check()) {
            auth('teacher')->user()->logout;
            $request->session()->invalidate();
            return redirect()->route('login', 'teacher');
        }
    }
}

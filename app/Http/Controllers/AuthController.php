<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function showChangePassword () {
        return response()->view('cms.auth.change-password');
    }

    public function changePassword (Request $request) {
        $validator = Validator($request->all(), [
            'new_password' => 'required|string|min:8|max:50',
            'current_password' => 'required|string|min:8|max:50',
            'confirmation_password' => 'required|string|min:8|max:50',
        ]);
        //
        if (!$validator->fails()) {
            $guard = auth('teacher')->check() ? 'teacher' : 'student';
            $user = auth($guard)->user();

            if (!Hash::check($request->get('current_password'), auth($guard)->user()->password)) {
                return response()->json([
                    'message' => 'Wrong password',
                ], Response::HTTP_BAD_REQUEST);
            }
            if ($request->get('new_password') != $request->get('confirmation_password')) {
                return response()->json([
                    'message' => 'Doesn\'t matches passwords',
                ], Response::HTTP_BAD_REQUEST);
            }

            $user->password = Hash::make($request->get('new_password'));
            $isSaved = $user->save();

            return response()->json([
                'message' => $isSaved ? 'Password changed successfully' : 'Faild to change password',
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

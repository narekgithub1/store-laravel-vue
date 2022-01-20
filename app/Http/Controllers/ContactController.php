<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation;



class ContactController extends Controller
{

    public function __construct()
    {

    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
                'name' => 'required',
                'email' => 'required|email|unique:users|max:25',
                'password' => 'required|min:6',
                'role_id' => 'required',
            ]);

            if ($validator->fails()) {
                ($errors = $validator->errors());
            }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ];

        $user = Contact::create($data);

        return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json([
                $errors ], 400);
        }

    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->toArray(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

            if ($validator->fails()) {
                ($errors = $validator->errors());
            }

        $user = Contact::where([
            'email' => $request->email
        ])->first();

        if (!Hash::check($request['password'], $user->password)) {
            return response([
                'massage' => 'password not the same'
            ], 401);
        }
        $token = \Auth::login($user);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            $token = $this->respondWithToken($token);
            $output = [

                'massage' => 'user logged',
                'code' => '201',
                'token' => $token,
                'user' => \Auth::user(),
            ];
        }
        return response()->json($output);
        }catch (\Exception $e) {
            return response()->json([$errors ],500);
        }
    }

    public function logout()
    {
        Auth::logout();

    }

    public function showAllUser()
    {
        return response()->json(Contact::all());
    }

    public function getAuthUser()
    {
        try {
            $user = auth()->user();
            return response()->json([
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = Contact::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 201);
    }

    public function delete($id)
    {
        Contact::findOrFail($id)->delete();
        return response('delete', 200);
    }


}



<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTodosRequest;
use App\Http\Requests\LoginRequest;
use App\Models\todo;
use App\Models\user;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validator = $request->getAttributes();

        $email = $validator['email'];
        $password = $validator['password'];

        $user = user::where('email', $email)->first();
        if ($user) {
            if ($password == $user->password) {
                $jwt = $this->jwt(
                    [
                        "alg" => "HS256",
                        "typ" => "JWT",
                    ],
                    [
                        "sub" => "{$user->id}:{$user->email}", // sub biasanya berisi data unique dari user
                        "name" => "example",
                        "iat" => time(), // iat atau singkatan dari issues at adalah waktu saat token dibuat (dalam satuan second)
                    ],
                    "Secret" // secret
                );

                $user->token = $jwt;
                $user->save();
                return response()->json([
                    "status" => true,
                    "message" => "Login Successfully",
                    "token" => $jwt
                ], 200);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                ], 400);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Cannot find user with E-mail : $email",
            ], 400);
        }
    }

    public function getalltodos()
    {
        $data = todo::all();
        return response()->json([
            "status" => true,
            "message" => "Get All Todos Successfully",
            "data" => $data,
        ], 200);

    }

    public function addtodos(AddTodosRequest $request)
    {
        $validator = $request->getAttributes();
        $id = $request->id;
        $title = $validator['title'];
        $detail = $request->detail;
        $status = $validator['status'];

        $addtodos = todo::create([
            'id' => $id,
            'title' => $title,
            'detail' => $detail,
            'status' => $status,
        ]);
        if(!$addtodos){
            return response()->json([
                'success' => false,
                'message' => 'Add data Failed',
            ],400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data Success Added',
            'data' => $addtodos,
        ],200);
    }
    public function updatetodos(AddTodosRequest $request)
    {
        $validator = $request->getAttributes();
        $id = $request->id;
        $title = $validator['title'];
        $detail = $request->detail;
        $status = $validator['status'];

        $todos = todo::where('id', $id)->first();
        if (!$todos) {
            return response()->json([
                "status" => false,
                "message" => "Todos not found",
            ], 400);
        }

        $todos->title = $title;
        $todos->detail = $detail;
        $todos->status = $status;
        $todos->save();
        return response()->json([
            'success' => true,
            'message' => 'Data Success Updated',
            'data' => $todos,
        ],200);
    }
    public function deletetodos($id)
    {
        $todos = todo::where('id',$id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Success Deleted',
        ],200);
    }





    //================== JWT ==============\\
    private function base64url_encode(String $data): String
    {
        $base64 = base64_encode($data); // ubah json string menjadi base64
        $base64url = strtr($base64, '+/', '-_'); // ubah char '+' -> '-' dan '/' -> '_'

        return rtrim($base64url, '='); // menghilangkan '=' pada akhir string
    }

    private function sign(String $header, String $payload, String $secret): String
    {
        $signature = hash_hmac('sha256', "{$header}.{$payload}", $secret, true);
        $signature_base64url = $this->base64url_encode($signature);

        return $signature_base64url;
    }

    private function jwt(array $header, array $payload, String $secret): String
    {
        $header_json = json_encode($header);
        $payload_json = json_encode($payload);

        $header_base64url = $this->base64url_encode($header_json);
        $payload_base64url = $this->base64url_encode($payload_json);
        $signature_base64url = $this->sign($header_base64url, $payload_base64url, $secret);

        $jwt = "{$header_base64url}.{$payload_base64url}.{$signature_base64url}";

        return $jwt;
    }
}

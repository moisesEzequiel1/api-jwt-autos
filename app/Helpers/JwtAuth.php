<?php 

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB; 
use App\Models\User; 


class JwtAuth{
    public $key;

    public function __construct(){
        $this->key ='clave-esesafadfadfadf-dfadfadfdf32e93286715rjofq';
    }

    public function signup($email, $password, $getToken=null){
        $user = User::where([
            'email'     =>$email,
            'password'  =>$password, 
        ])->first();

        $signup = false;

        if(is_object($user)){
            $signup = true;
        }
        if(!$signup){
            return [
                'status' => 'error', 
                'message' => 'login fallido', 
            ];
        }
        $token = [
            'sub'   => $user->id, 
            'email'   => $user->id, 
            'name'   => $user->id, 
            'surname'   => $user->id, 
            'iat'   => $user->id, 
            'exp'   => time() + (7 *24* 60*60),
        ];

        $jwt = JWT::encode($token, $this->key, 'HS256');
        $decoded = JWT::decode($jwt, $this->key, ['HS256']);

        if(!is_null($getToken)){
            return $jwt;
        }
        return $decoded; 
    }
    public function checkToken($jwt, $getIdentity=false){
            $auth = false;
            $decoded = false;

            try{
                $decoded = JWT::decode($jwt, $this->key, ['HS256']);               
            }catch (\UnexpectedValueException | \DomainException $e) {
                $auth = false;
            }
            if(!empty($decoded) && is_object($decoded) && isset ($decoded->sub)){
                $auth = true;
            }
            else{
                $auth = false;
            }
            if($getIdentity){
                return $decoded;
            }
                return $auth;
    }
}

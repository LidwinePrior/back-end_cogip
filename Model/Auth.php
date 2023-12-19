<?php

namespace App\Model;

use Firebase\JWT\JWT;
use App\Model\BaseModel;
use App\Controller\HomeController;
use App\Model\User;

class Auth extends BaseModel
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function authenticate($email, $password)
    {
        // Création d'une instance de la classe User
        try
        {
            $userModel = new User();
        
            // Appel de la méthode getUserByEmail
            $user = $userModel->getUserByEmail($email);

            $jsonUser = json_decode($user, true);
            
            $pwdUser = $jsonUser['data']['password'];
       
        // Vérification du mot de passe
        if ($password === $pwdUser) 
        {
            // Génération du token
            $token = $this->generateToken($email, $password);
            // Envoi du token dans la réponse
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Origins, X-Requested-With, Content-type, Accept');
            http_response_code(200);
            echo json_encode([
                'message' => 'Authentification réussie',
                'token' => $token,
            ]);
            return $token;
        } 
        else 
        {
            throw new \Exception("Email ou mot de passe incorrect", 401);
        }
        }
        catch (\Throwable $e) 
        {
            http_response_code($e->getCode());
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    private function generateToken($email, $password)
    {
        // Génération du token JWT
        $tokenPayload = 
        [
            "iss" => "localhost:5173",
            "aud" => "localhost:5173",
            "iat" => time(),
            "exp" => time() + 3600,
            "email" => $email,
            "password" => $password,
        
        ];
        $token = JWT::encode($tokenPayload, $this->secretKey, 'HS256');
        return $token;
    }
 
    public function verifyToken($token, $secretKey)
    {
    
        try 
        {
            $decoded = JWT::decode($token, $this->secretKey);
            return $decoded;
        } 
        catch (\Firebase\JWT\ExpiredException $e) 
        {
            // Token has expired
            return null;
        } 
        catch (\Exception $e) 
        {
            // Token is invalid
            return null;
        }
    }
}


<?php
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Auth
{
    private $firebase;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');
        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
    }

    public function loginUser($email, $password)
    {
        // Code pour se connecter à un utilisateur avec Firebase
        // ...
    }

    public function createUser($email, $password)
    {
        // Code pour créer un utilisateur avec Firebase
        // ...
    }
}

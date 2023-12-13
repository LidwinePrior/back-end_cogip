<?php
namespace App\Model;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth\SignInResult;

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/path/to/your/firebase/credentials.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();

$auth = $firebase->getAuth();

function registerUser($email, $password) {
    global $auth;
    try {
        $userProperties = [
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'disabled' => false,
        ];
        $createdUser = $auth->createUser($userProperties);
        return $createdUser->uid;
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}

function loginUser($email, $password) {
    global $auth;
    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $idTokenString = $signInResult->idToken();
        return $idTokenString; // This is the API token
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}
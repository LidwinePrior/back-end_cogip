<?php

namespace App\Model;

use App\Model\BaseModel;
use App\Model\Error;
use Firebase\JWT\JWT;
use PDO;

class User extends BaseModel
{

    ////////GET ALL USERS//////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllUsers()
    {

        //requête pour récupérer tous les users
        $query = $this->connection->prepare(
            "SELECT roles.name AS role_name, users.first_name, users.last_name, users.email, users.password
            FROM roles
            JOIN users ON roles.id = users.role_id
            JOIN roles_permission ON roles.id = roles_permission.role_id
            JOIN permissions ON roles_permission.permission_id = permissions.id"
        );

        $query->execute();
        $usersData = $query->fetchAll(PDO::FETCH_ASSOC);

        // Convertir en JSON
        // JSON_PRETTY_PRINT -> meilleure lisibilité lors de l'affichage.

        $jsonData = json_encode($usersData, JSON_PRETTY_PRINT);

        if (empty($usersData)) 
        {
            $statusCode = 500;
            $status = 'error';
        }
        else
        {
            $statusCode = 200;
            $status = 'success';
        }
    
        $response = 
        [
            'message' => 'List of all users',
            'code' => $statusCode,
            'content-type' => 'application/json',
            'status' => $status,
            'data' => $usersData,
        ];
    
        $jsonData = json_encode($response, JSON_PRETTY_PRINT);
    
        header('Content-Type: application/json');
        http_response_code($statusCode);
    
        echo $jsonData;
    }



    //////GET FIRST FIVE USERS/////////////////////////////////////////////////////////////////////////////////////////

    public function getFirstFiveUsers()
    {
        $query = $this->connection->prepare(
            "SELECT roles.name AS role_name, users.first_name, users.last_name, users.email, users.password
                    FROM roles
                    JOIN users ON roles.id = users.role_id
                    JOIN roles_permission ON roles.id = roles_permission.role_id
                    JOIN permissions ON roles_permission.permission_id = permissions.id
                    LIMIT 5 OFFSET 0"
        );

        $query->execute();
        $usersData = $query->fetchAll(PDO::FETCH_ASSOC);

        // Convertir en JSON
        // JSON_PRETTY_PRINT -> meilleure lisibilité lors de l'affichage.
        $jsonData = json_encode($usersData, JSON_PRETTY_PRINT);

        if (empty($usersData))
        {
            $statusCode = 500;
            $status = 'error';
        }
        else
        {
            $statusCode = 200;
            $status = 'success';
        }
    
        $response = 
        [
            'message' => 'List of 5 users',
            'code' => $statusCode,
            'content-type' => 'application/json',
            'status' => $status,
            'data' => $usersData,
        ];
    
        $jsonData = json_encode($response, JSON_PRETTY_PRINT);
    
        header('Content-Type: application/json');
        http_response_code($statusCode);
    
        echo $jsonData;
    }


    // GET USER BY ID  ////////////////////////////////////////////////////////////////////////////////////////////
    public function show($id)
    {
        $query = $this->connection->prepare(
            "SELECT roles.name AS role_name, users.first_name, users.last_name, users.email, users.password
                    FROM roles
                    JOIN users ON roles.id = users.role_id
                    JOIN roles_permission ON roles.id = roles_permission.role_id
                    JOIN permissions ON roles_permission.permission_id = permissions.id
                    WHERE users.id = :id"
        );
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $companiesid = $query->fetchAll(PDO::FETCH_ASSOC);

        // Convertir en JSON
        $jsonData = json_encode($companiesid, JSON_PRETTY_PRINT);

        if (empty($companiesid)) 
        {
            $statusCode = 500;
            $status = 'error';
        } 
        else 
        {
            $statusCode = 200;
            $status = 'success';
        }
    
        $response = 
        [
            'message' => 'users',
            'code' => $statusCode,
            'content-type' => 'application/json',
            'status' => $status,
            'data' => $companiesid,
        ];
    
        $jsonData = json_encode($response, JSON_PRETTY_PRINT);
    
        header('Content-Type: application/json');
        http_response_code($statusCode);
    
        echo $jsonData;
    }

    // DELETE USER BY ID ////////////////////////////////////////////////////////////////////////////////////////////
    
    public function delete($id){
        $query = $this->connection->prepare(
            "DELETE FROM users WHERE id = :id"
        );
    
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $companiesid = $query->fetchAll(PDO::FETCH_ASSOC);

        // Convertir en JSON
        $jsonData = json_encode($companiesid, JSON_PRETTY_PRINT);

        if (empty($companiesid)) 
        {
            $statusCode = 500;
            $status = 'error';
        } 
        else 
        {
            $statusCode = 200;
            $status = 'success';
        }
    
        $response = 
        [
            'message' => 'users',
            'code' => $statusCode,
            'content-type' => 'application/json',
            'status' => $status,
            'data' => $companiesid,
        ];
    
        $jsonData = json_encode($response, JSON_PRETTY_PRINT);
    
        header('Content-Type: application/json');
        http_response_code($statusCode);
    
        echo $jsonData;

    }
    public function update($id)
    {
        $query = $this->connection->prepare(
            "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password WHERE id = :id"
        );
    
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
    
        $query->execute();
        $companiesid = $query->fetchAll(PDO::FETCH_ASSOC);

        // Convertir en JSON
        $jsonData = json_encode($companiesid, JSON_PRETTY_PRINT);

        if (empty($companiesid)) 
        {
            $statusCode = 500;
            $status = 'error';
        } 
        else 
        {
            $statusCode = 200;
            $status = 'success';
        }
    
        $response = 
        [
            'message' => 'users',
            'code' => $statusCode,
            'content-type' => 'application/json',
            'status' => $status,
            'data' => $companiesid,
        ];
    
        $jsonData = json_encode($response, JSON_PRETTY_PRINT);
    
        header('Content-Type: application/json');
        http_response_code($statusCode);
    
        echo $jsonData;
    }
    public function login($email, $password)
    {
        $query = $this->connection->prepare(
            "SELECT * FROM users WHERE email = :email AND password = :password"
        );

        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);

        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (empty($user)) {
            $statusCode = 401; // Unauthorized
            $status = 'error';
            $message = 'Invalid credentials';
        } else {
            // Generate JWT token
            $token = $this->generateToken($user['id'], $user['email'], $user['role']);

            $statusCode = 200;
            $status = 'success';
            $message = 'Login successful';
            $data = ['token' => $token];

            // You may want to store the token in the database or in a secure session.
            // For simplicity, we are returning it in the response.
        }

        $response = [
            'message' => $message,
            'code' => $statusCode,
            'content-type' => 'application/json',
            'status' => $status,
            'data' => $data ?? null,
        ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }

    private function generateToken($userId, $email, $role)
    {
        $secretKey = 'your_secret_key'; // Replace with your actual secret key

        $payload = [
            'user_id' => $userId,
            'email' => $email,
            'role' => $role,
            'exp' => time() + (60 * 60), // Token expiration time (1 hour)
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

}
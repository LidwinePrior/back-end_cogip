<?php

namespace App\Model;

use App\Model\BaseModel;
use App\Model\Error;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        
        if (empty($usersData))
        {       // Si aucun user n'est trouvé, on retourne une erreur
            return Error::createErrorResponse('No users found', Response::HTTP_NOT_FOUND);
        }
        else
        {       // Convertir en JSON 
            return new JsonResponse($usersData, JSON_PRETTY_PRINT);
    }
 
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

        // Définir les en-têtes pour indiquer que la réponse est au format JSON
        header('Content-Type: application/json');
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
        // Définir les en-têtes pour indiquer que la réponse est au format JSON
        header('Content-Type: application/json');
        echo json_encode($companiesid, JSON_PRETTY_PRINT);
    }

}
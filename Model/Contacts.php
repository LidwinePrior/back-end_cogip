<?php

namespace App\Model;

use App\Model\BaseModel;
use PDO;
use Exception;

class Contacts extends BaseModel
{
    // GET METHOD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllContacts()
    {
        $query = $this->connection->prepare(
            "SELECT contacts.id, contacts.name, contacts.email, contacts.phone, contacts.created_at AS contact_creation, companies.name AS company_name
         FROM types 
         JOIN companies ON types.id = companies.type_id
         JOIN contacts ON companies.id = contacts.company_id
         ORDER BY contacts.name ASC"
        );
        $query->execute();
        $companiesData = $query->fetchAll(PDO::FETCH_ASSOC);


        if (empty($companiesData)) {
            $statusCode = 500;
            $status = 'error';
        } else {
            $statusCode = 200;
            $status = 'success';
        }

        $response =
            [
                'message' => 'List of all contacts',
                'content-type' => 'application/json',
                'code' => $statusCode,
                'status' => $status,
                'data' => $companiesData,
            ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }



    public function getFirstFiveContacts()
    {
        $query = $this->connection->prepare(
            "SELECT contacts.id, contacts.name, contacts.email, contacts.phone, contacts.created_at AS contact_creation, companies.name AS company_name
         FROM types 
         JOIN companies ON types.id = companies.type_id
         JOIN contacts ON companies.id = contacts.company_id
         ORDER BY contacts.created_at DESC
         LIMIT 5 OFFSET 0"
        );
        $query->execute();
        $companiesData = $query->fetchAll(PDO::FETCH_ASSOC);


        if (empty($companiesData)) {
            $statusCode = 500;
            $status = 'error';
        } else {
            $statusCode = 200;
            $status = 'success';
        }

        $response =
            [
                'message' => 'List of 5 contacts',
                'content-type' => 'application/json',
                'code' => $statusCode,
                'status' => $status,
                'data' => $companiesData,
            ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }


    public function show($contactId)
    {
        $contactDetails = $this->getContactById($contactId);

        // Vérifier si la compagnie a été trouvée
        if (!$contactDetails) {
            $message = 'Contact not found';
            $statusCode = 404;
            $status = 'error';
        } else {
            $message = 'Contact details';
            $statusCode = 200;
            $status = 'success';
        }
        // Retourner une réponse JSON avec un statut d'erreur
        $response = [
            'message' => $message,
            'content-type' => 'application/json',
            'status' => $status,
            'code' => $statusCode,
            'data' => $contactDetails,
        ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }

    private function getContactById($contactId)
    {
        $query = $this->connection->prepare(
            "SELECT contacts.id, contacts.name, contacts.email, contacts.phone, contacts.created_at AS contact_creation, companies.name AS company_name
         FROM types 
         JOIN companies ON types.id = companies.type_id
         JOIN contacts ON companies.id = contacts.company_id
         WHERE contacts.id = :id"
        );
        $query->bindParam(':id', $contactId, PDO::PARAM_INT);
        $query->execute();
        $contactDetails = $query->fetch(PDO::FETCH_ASSOC);

        return $contactDetails;
    }


    // POST METHOD  //////////////////////////////////////////////////////////////////////////////////////////////
    public function createContact($contactName, $company_id, $email, $phone)
    {
        try {
            $query = $this->connection->prepare(
                "INSERT INTO contacts (name, company_id, email, phone) VALUES (:name, :company_id, :email, :phone)"
            );

            $query->bindParam(':name', $contactName);
            $query->bindParam(':company_id', $company_id);
            $query->bindParam(':email', $email);
            $query->bindParam(':phone', $phone);
            return $query->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    //vérifier si le contact existe déjà et récupérer son ID si c'est le cas
    public function getContactIdByName($contactName)
    {
        $query = $this->connection->prepare("SELECT id FROM contacts WHERE name= :contactName");
        $query->bindParam(':contactName', $contactName);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        //retourner l'ID du contact si une correspondance sinon retourner null
        return $result ? $result['id'] : null;
    }



    // DELETE CONTACT BY ID //////////////////////////////////////////////////////////////////////////////////////////////

    public function delete($id)
    {
        $query = $this->connection->prepare(
            "DELETE FROM contacts WHERE id = :id"
        );

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $query->execute();

        // Vérifier si la suppression a réussi
        if ($success) {
            $statusCode = 200;
            $status = 'success';
            $message = 'Contact deleted successfully.';
        } else {
            $statusCode = 500;
            $status = 'error';
            $message = 'Failed to delete contact.';
        }

        $response = [
            'message' => $message,
            'content-type' => 'application/json',
            'code' => $statusCode,
            'status' => $status,
        ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }



    //UPDATE CONTACT //////////////////////////////////////
    public function update($id)
    {
        try {
            // Récupérer le corps de la requête JSON
            $body = file_get_contents('php://input');
            $data = json_decode($body, true);
            // var_dump($data);
            // Vérifier si le contact existe déjà
            $existingContact = $this->getContactById($id);

            // Si le contact n'existe pas, retourner un code d'erreur
            if (!$existingContact) {
                http_response_code(404);
                echo json_encode(['message' => 'Contact not found']);
                exit();
            }

            // Mettre à jour le contact
            $query = $this->connection->prepare(
                "UPDATE contacts SET name = :name , company_id = :company_id, email = :email, phone = :phone WHERE id = :id"
            );

            $query->bindParam(':name', $data['name']);
            $query->bindParam(':company_id', $data['company_id']);
            $query->bindParam(':email', $data['email']);
            $query->bindParam(':phone', $data['phone']);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $success = $query->execute();

            // Vérifier si la mise à jour a réussi
            if ($success) {
                $statusCode = 200;
                $status = 'success';
                $message = 'Contact updated successfully.';
            } else {
                $statusCode = 500;
                $status = 'error';
                $message = 'Failed to update contact.';
            }

            $response = [
                'message' => $message,
                'content-type' => 'application/json',
                'code' => $statusCode,
                'status' => $status,
            ];
            $jsonData = json_encode($response, JSON_PRETTY_PRINT);

            header('Content-Type: application/json');
            http_response_code($statusCode);

            echo $jsonData;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

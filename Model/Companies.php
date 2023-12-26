<?php

namespace App\Model;

use App\Model\BaseModel;
use PDO;
use Exception;

class Companies extends BaseModel
{

    // GET ALL COMPANIES   ////////////////////////////////////////////////////////////////////
    public function getAllCompanies()
    {
        $query = $this->connection->prepare(
            "SELECT types.name AS type_name,companies.id, companies.name AS company_name, companies.country, companies.tva, companies.created_at AS company_creation
        FROM types 
        JOIN companies ON types.id = companies.type_id
        ORDER BY companies.name ASC"
        );

        $query->execute();
        $companiesData = $query->fetchAll(PDO::FETCH_ASSOC);



        // Définir les en-têtes pour indiquer que la réponse est au format JSON
        if (empty($companiesData)) {
            $statusCode = 500;
            $status = 'error';
        } else {
            $statusCode = 200;
            $status = 'success';
        }

        $response =
            [
                'message' => 'List of all companies',
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


    // GET FIRST FIVE COMPANIES //////////////////////////////////////////////////////////////////////
    public function getFirstFiveCompanies()
    {
        $query = $this->connection->prepare(
            "SELECT types.name AS type_name,companies.id, companies.name AS company_name, companies.country, companies.tva, companies.created_at AS company_creation
         FROM types 
         JOIN companies ON types.id = companies.type_id
         ORDER BY companies.created_at DESC
         LIMIT 5 OFFSET 0"
        );
        $query->execute();
        $companiesData = $query->fetchAll(PDO::FETCH_ASSOC);

        // Définir les en-têtes pour indiquer que la réponse est au format JSON
        if (empty($companiesData)) {
            $statusCode = 500;
            $status = 'error';
        } else {
            $statusCode = 200;
            $status = 'success';
        }

        $response =
            [
                'message' => 'List of 5 companies',
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

    // GET COMPANY BY ID ///////////////////////////////////////////////////////////////
    public function show($companyId)
    {
        // Récupérer les détails de la compagnie par ID
        $companyDetails = $this->getCompanyById($companyId);

        // Vérifier si la compagnie a été trouvée
        if (!$companyDetails) {
            http_response_code(404);
            $message = 'Company not found';
            $statusCode = 404;
            $status = 'error';
        } else {
            $message = 'Company details';
            $statusCode = 200;
            $status = 'success';
        }
        // Retourner une réponse JSON avec un statut d'erreur
        $response = [
            'message' => $message,
            'content-type' => 'application/json',
            'status' => $status,
            'code' => $statusCode,
            'data' => $companyDetails,
        ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }

    // Méthode pour récupérer les détails de la compagnie par son identifiant
    private function getCompanyById($companyId)
    {
        $query = $this->connection->prepare(
            "SELECT
            types.name AS type_name,
            companies.id,
            companies.name AS company_name,
            companies.country,
            companies.tva,
            companies.created_at AS company_creation,
            GROUP_CONCAT(DISTINCT contacts.id) AS contact_id,
            GROUP_CONCAT(DISTINCT last_invoices.invoice_id) AS invoice_id
        FROM types
        JOIN companies ON types.id = companies.type_id
        LEFT JOIN contacts ON companies.id = contacts.company_id
        LEFT JOIN (
            SELECT DISTINCT id AS invoice_id, id_company, created_at
            FROM invoices
            WHERE id_company = :id
            ORDER BY created_at DESC
            LIMIT 5
        ) AS last_invoices ON companies.id = last_invoices.id_company
        WHERE companies.id = :id
        GROUP BY
            types.name,
            companies.id,
            companies.name,
            companies.country,
            companies.tva,
            companies.created_at
        ORDER BY MAX(last_invoices.created_at) DESC;
        "
        );
        $query->bindParam(':id', $companyId, PDO::PARAM_INT);
        $query->execute();

        // Utiliser fetch au lieu de fetchAll, car GROUP_CONCAT génère une seule ligne
        $companyDetails = $query->fetch(PDO::FETCH_ASSOC);

        // Vérifier si $companyDetails est null ou fals
        if (!$companyDetails) {
            return null;
        }

        // Vérifier si 'contact_id' existe et n'est pas null ou false
        if (isset($companyDetails['contact_id']) && $companyDetails['contact_id'] !== null && $companyDetails['contact_id'] !== false) {
            // Séparer les noms des contacts en un tableau
            $companyDetails['contacts'] = explode(',', $companyDetails['contact_id']);
            unset($companyDetails['contact_id']);
        } else {
            // Si 'contact_id' n'existe pas, est null ou est false, définir un tableau vide
            $companyDetails['contacts'] = [];
        }

        // Vérifier si 'invoice_id' existe et n'est pas null ou false
        if (isset($companyDetails['invoice_id']) && $companyDetails['invoice_id'] !== null && $companyDetails['invoice_id'] !== false) {
            // Séparer les noms des factures en un tableau
            $companyDetails['invoices'] = explode(',', $companyDetails['invoice_id']);
            unset($companyDetails['invoice_id']);
        } else {
            // Si 'invoice_id' n'existe pas, est null ou est false, définir un tableau vide
            $companyDetails['invoices'] = [];
        }

        return $companyDetails;
    }




    // POST NEW COMPANY  ////////////////////////////////////////////////////////////////
    public function createCompany($companyName, $type_id, $country, $tva)
    {
        try {
            // Insérer dans la table Companies
            $query = $this->connection->prepare("INSERT INTO companies (name, type_id, country, tva) VALUES (:name, :type_id, :country, :tva)");

            $query->bindParam(':name', $companyName);
            $query->bindParam(':type_id', $type_id);
            $query->bindParam(':country', $country);
            $query->bindParam(':tva', $tva);
            return $query->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    //vérifier si la company existe déjà et récupérer son ID si c'est le cas
    public function getCompanyIdByName($companyName)
    {
        $query = $this->connection->prepare("SELECT id FROM companies WHERE name = :companyName");
        $query->bindParam(':companyName', $companyName);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        //retourner l'ID de l'entreprise si une correspondance sinon retourner null
        return $result ? $result['id'] : null;
    }



    // DELETE COMPANY BY ID ////////////////////////////////////////////////////////////////////////////////////////////
    public function delete($id)
    {
        $query = $this->connection->prepare(
            "DELETE FROM companies WHERE id = :id"
        );

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $query->execute();


        // Vérifier si la suppression a réussi
        if ($success) {
            $statusCode = 200;
            $status = 'success';
            $message = 'Company deleted successfully.';
        } else {
            $statusCode = 500;
            $status = 'error';
            $message = 'Failed to delete company.';
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
    // UPDATE COMPANY ///////////////////////////////////////////////////
    public function update($id)
    {
        try {
            // Récupérer le corps de la requête JSON
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            // Vérifier si la company existe déjà
            $existingCompanyId = $this->getCompanyById($id);

            // Si la company n'existe pas, retourner un code d'erreur
            if (!$existingCompanyId) {
                http_response_code(404);
                echo json_encode(['message' => 'Company not found']);
                exit();
            }

            // Vérifier si une autre company avec le même nom existe déjà
            $otherCompanyId = $this->getCompanyIdByName($data->name);

            // Si une autre company avec le même nom existe et ce n'est pas la même que celle que vous mettez à jour, retourner un code d'erreur
            if ($otherCompanyId && $otherCompanyId !== $id) {
                http_response_code(409);
                echo json_encode(['message' => 'Company with the same name already exists']);
                exit();
            }

            // Mettre à jour la company
            $query = $this->connection->prepare(
                "UPDATE companies SET name = :name, type_id = :type_id, country = :country, tva = :tva WHERE id = :id"
            );

            $query->bindParam(':name', $data->name);
            $query->bindParam(':type_id', $data->type_id);
            $query->bindParam(':country', $data->country);
            $query->bindParam(':tva', $data->tva);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $success = $query->execute();

            // Vérifier si la mise à jour a réussi
            if ($success) {
                $statusCode = 200;
                $status = 'success';
                $message = 'Company updated successfully.';
            } else {
                $statusCode = 500;
                $status = 'error';
                $message = 'Failed to update company.';
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

<?php

namespace App\Model;

use App\Model\BaseModel;
use PDO;
use Exception;

class Invoices extends BaseModel
{
    // GET ALL INVOICES //////////////////////////////////////////////////////////////////////////
    public function getAllInvoices()
    {
        $query = $this->connection->prepare(
            "SELECT invoices.id, invoices.ref, invoices.date_due, invoices.created_at AS invoice_creation, companies.name AS company_name
        FROM types 
         JOIN companies ON types.id = companies.type_id
         JOIN invoices ON companies.id = invoices.id_company
         ORDER BY invoices.created_at DESC"
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
                'message' => 'List of all invoices',
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




    //GET FIRST FIVE COMPANIES ///////////////////////////////////////////////////////////////////////////
    public function getFirstFiveInvoices()
    {
        $query = $this->connection->prepare(
            "SELECT invoices.id, invoices.ref, invoices.date_due, invoices.created_at AS invoice_creation, companies.name AS company_name
        FROM types 
         JOIN companies ON types.id = companies.type_id
         JOIN invoices ON companies.id = invoices.id_company
         ORDER BY invoices.created_at DESC
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
                'message' => 'List of 5 invoices',
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



    // GET INVOICE BY ID ///////////////////////////////////////////////////////////////////////////////////////////////
    public function show($invoiceId)
    {
        $invoiceDetails = $this->getInvoiceById($invoiceId);

        // Vérifier si la compagnie a été trouvée
        if (!$invoiceDetails) {
            $message = 'Invoice not found';
            $statusCode = 404;
            $status = 'error';
        } else {
            $message = 'Invoice details';
            $statusCode = 200;
            $status = 'success';
        }
        // Retourner une réponse JSON avec un statut d'erreur
        $response = [
            'message' => $message,
            'content-type' => 'application/json',
            'status' => $status,
            'code' => $statusCode,
            'data' => $invoiceDetails,
        ];

        $jsonData = json_encode($response, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo $jsonData;
    }

    private function getInvoiceById($invoiceId)
    {
        $query = $this->connection->prepare(
            "SELECT invoices.id, invoices.ref, invoices.date_due, invoices.created_at AS invoice_creation, companies.name AS company_name
        FROM types 
         JOIN companies ON types.id = companies.type_id
         JOIN invoices ON companies.id = invoices.id_company
         WHERE invoices.id = :id"
        );
        $query->bindParam(':id', $invoiceId, PDO::PARAM_INT);
        $query->execute();
        $invoiceDetails = $query->fetch(PDO::FETCH_ASSOC);
        return $invoiceDetails;
    }


    // POST METHOD /////////////////////////////////////////////////////////////////////////////////
    public function createInvoice($ref, $id_company, $date_due)
    {
        try {
            $query = $this->connection->prepare(
                "INSERT INTO invoices (ref, id_company,date_due) VALUES (:ref, :id_company, :date_due)"
            );

            $query->bindParam(':ref', $ref);
            $query->bindParam(':id_company', $id_company);
            $query->bindParam(':date_due', $date_due);
            return $query->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    //vérifier si l'invoice existe déjà et récupérer son ID si c'est le cas
    public function getInvoiceIdByName($ref)
    {
        $query = $this->connection->prepare("SELECT id FROM invoices WHERE ref = :ref");
        $query->bindParam(':ref', $ref);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        //retourner l'ID de l'invoice si une correspondance sinon retourner null
        return $result ? $result['id'] : null;
    }


    // DELETE INVOICE BY ID ////////////////////////////////////////////////////////////////////////////////////////////
    public function delete($id)
    {
        $query = $this->connection->prepare(
            "DELETE FROM invoices WHERE id = :id"
        );

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $query->execute();

        // Vérifier si la suppression a réussi
        if ($success) {
            $statusCode = 200;
            $status = 'success';
            $message = 'Invoice deleted successfully.';
        } else {
            $statusCode = 500;
            $status = 'error';
            $message = 'Failed to delete invoice.';
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


    //  UPDATE INVOICE //////////////////////////////////////////////////
    public function updateInvoice($id)
    {
        try {
            // Récupérer le corps de la requête JSON
            $body = file_get_contents('php://input');
            $data = json_decode($body);
            // var_dump($data);
            // Vérifier si la facture existe déjà
            $existingInvoice = $this->getInvoiceById($id);

            // Si la facture n'existe pas, retourner une erreur
            if (!$existingInvoice) {
                http_response_code(400);
                echo json_encode(['message' => 'Invoice not found']);
                exit();
            }

            // Mettre à jour le type
            $query = $this->connection->prepare(
                "UPDATE invoices SET ref = :ref, id_company = :id_company, date_due = :date_due WHERE id = :id"
            );

            $query->bindParam(':ref', $data->ref);
            $query->bindParam(':id_company', $data->id_company);
            $query->bindParam(':date_due', $data->date_due);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $success = $query->execute();
            // Vérifier si la mise à jour a réussi
            if ($success) {
                $statusCode = 200;
                $status = 'success';
                $message = 'Invoice updated successfully.';
            } else {
                $statusCode = 500;
                $status = 'error';
                $message = 'Failed to update invoice.';
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

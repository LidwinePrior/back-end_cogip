<?php

namespace App\Routes;

use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Model\Auth;


$router = new Router();

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH");
    header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token, Access-Control-Allow-Headers, Access-Control-Request-Method, Access-Control-Request-Headers');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Middleware pour vérifier le token dans les requêtes GET
$router->before('GET', '/api/(.*)', function () {
    $_SERVER['HTTP_AUTHORIZATION'] ?? null;
});
$router->before('POST', '/api/(.*)', function () {
    $_SERVER['HTTP_AUTHORIZATION'] ?? null;
});


// Code pour gérer les requêtes OPTIONS
$router->options('/api/(.*)', function () {
    // Définir les en-têtes CORS pour les requêtes OPTIONS
    // Ces en-têtes doivent être définis pour permettre les requêtes CORS
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token, Access-Control-Allow-Headers, Access-Control-Request-Method, Access-Control-Request-Headers');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day

    // Répondre avec un statut OK (200) pour les requêtes OPTIONS
    http_response_code(200);
    exit();
});

$router->mount('/api', function () use ($router) {
    // LOGIN /////////////////////////////////////////////////////////////////
    // $router->get('/login', function () use ($auth) {

    //     $email = $_GET['email'] ?? 'john.doe@example.com';
    //     $password = $_GET['password'] ?? 'test123';

    //     $auth->authenticate($email, $password);
    // });
    // GET METHOD  //////////////////////////////////////////////////////

    // USERS /////////////////////////////////////////////////////////////////
    $router->get('/users', function () {
        (new HomeController())->allUsers();
    });
    $router->get('/fiveusers', function () {
        (new HomeController())->fiveUsers();
    });
    $router->get('/users/(\d+)', function ($id) {
        (new HomeController())->showUser($id);
    });

    // COMPANIES /////////////////////////////////////////////////////////////////
    $router->get('/companies', function () {
        (new HomeController())->allCompanies();
    });
    $router->get('/fivecompanies', function () {
        (new HomeController())->fiveCompanies();
    });
    $router->get('/companies/(\d+)', function ($id) {
        (new HomeController())->showCompany($id);
    });

    // INVOICES /////////////////////////////////////////////////////////////////
    $router->get('/invoices', function () {
        (new HomeController())->allInvoices();
    });
    $router->get('/fiveinvoices', function () {
        (new HomeController())->fiveInvoices();
    });
    $router->get('/invoices/(\d+)', function ($id) {
        (new HomeController())->showInvoice($id);
    });

    // CONTACTS /////////////////////////////////////////////////////////////////
    $router->get('/contacts', function () {
        (new HomeController())->allContacts();
    });
    $router->get('/fivecontacts', function () {
        (new HomeController())->fiveContacts();
    });
    $router->get('/contacts/(\d+)', function ($id) {
        (new HomeController())->showContact($id);
    });

    // POST METHOD  ////////////////////////////////////////////////////////////////

    // COMPANY  /////////////////////////////////
    $router->post('/add-company', function () {
        (new HomeController())->createNewCompany();
    });

    // CONTACT /////////////////////////////////////////
    $router->post('/add-contact', function () {
        (new HomeController())->createNewContact();
    });

    // INVOICE ////////////////////////////////////////////
    $router->post('/add-invoice', function () {
        (new HomeController())->createNewInvoice();
    });

    // USER ////////////////////////////////////////////
    $router->post('/register', function () {
        (new HomeController())->createNewUser();
    });
    // DELETE METHOD  ////////////////////////////////////////////////////////////////

    // USER /////////////////////////////////////////////////////////////////////
    $router->delete('/del-user/(\d+)', function ($id) {
        (new HomeController())->delUser($id);
    });
    // COMPANY /////////////////////////////////////////////////////////////////
    $router->delete('/del-company/(\d+)', function ($id) {
        (new HomeController())->delCompany($id);
    });
    // INVOICE /////////////////////////////////////////////////////////////////
    $router->delete('/del-invoice/(\d+)', function ($id) {
        (new HomeController())->delInvoice($id);
    });
    // CONTACT /////////////////////////////////////////////////////////////////
    $router->delete('/del-contact/(\d+)', function ($id) {
        (new HomeController())->delContact($id);
    });

    // PUT METHOD  ////////////////////////////////////////////////////////////////
    // COMPANY /////////////////////////////////////////////////////////////////
    $router->put('/update-company/(\d+)', function ($id) {
        (new HomeController())->updateCompany($id);
    });
    // INVOICE /////////////////////////////////////////////////////////////////
    $router->put('/update-invoice/(\d+)', function ($id) {
        (new HomeController())->updateInvoice($id);
    });
    // CONTACT /////////////////////////////////////////////////////////////////
    $router->put('/update-contact/(\d+)', function ($id) {
        (new HomeController())->updateContact($id);
    });
});

$router->run();

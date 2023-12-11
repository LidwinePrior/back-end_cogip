<?php

namespace App\Routes;

use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Core\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

$router = new Router();



$router->mount('/api', function () use ($router) {
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
    $router->post('/add-company', function (Request $request) {
        (new HomeController())->createNewCompany($request);
    });

    // CONTACT /////////////////////////////////////////
    $router->post('/add-contact', function (Request $request) {
        (new HomeController())->createNewContact($request);
    });

    // INVOICE ////////////////////////////////////////////
    $router->post('/add-invoice', function (Request $request) {
        (new HomeController())->createNewInvoice($request);
    });
});

$router->run();

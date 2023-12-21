
# Cogip API

## Mission

The COGIP API is developed to serve the accounting needs of the COGIP company. This API provides functionalities related to managing companies, contacts, and invoices.

[API Link](https://api-cogip-329f9c72c66d.herokuapp.com/)

## Mission

Install all the dependances using composer
Confirm PHP (POO) and MVC Structure
CRUD
Validation & Sanitization (controllers)



## Tech Stack

- **Server:**
  - PHP
  - POO (Object-Oriented Programming)
  - MVC (Model-View-Controller)
  - Namespace
  - [bramus/router](https://github.com/bramus/router) (A lightweight and simple object-oriented PHP Router)
  - [filp/whoops](https://github.com/filp/whoops) (PHP errors)
  - [dragonbe/vies](https://github.com/dragonbe/vies) (TVA validation)
  - [firebase/php-jwt](https://github.com/firebase/php-jwt) (Authentication)




## API Reference

### Companies

- **GET all companies**
  - `GET /api/companies`

- **GET last five companies**
  - `GET /api/fivecompanies`

- **GET company**
  - `GET /api/companies/${id}`

- **POST company**
  - `POST /api/add-company`

- **DELETE company**
  - `DELETE /api/del-company`

- **PUT company**
  - `PUT /api/update-company`

### Contacts

- **GET all contacts**
  - `GET /api/contacts`

- **GET last five contacts**
  - `GET /api/fivecontacts`

- **GET contact**
  - `GET /api/contcats/${id}`

- **POST contact**
  - `POST /api/add-contact`

- **DELETE contact**
  - `DELETE /api/del-contact`

- **PUT contact**
  - `PUT /api/update-contact`

### Invoices

- **GET all invoices**
  - `GET /api/invoices`

- **GET last five invoices**
  - `GET /api/fiveinvoices`

- **GET invoice**
  - `GET /api/invoices/${id}`

- **POST invoice**
  - `POST /api/add-invoice`

- **DELETE invoice**
  - `DELETE /api/del-invoice`

- **PUT invoice**
  - `PUT /api/update-invoice`



## Roles

### Lidwine

- Methods: GET, POST
- Sanitization & Validation
- Put the database online

### Mathias

- Method: DELETE
- Authentication
- CORS

### Together

- Router
- Method: PUT
- Deployment on Heroku



## Authors

[Lidwine](https://www.github.com/LidwinePrior) & [Mathias](https://github.com/PAZTEK1007)


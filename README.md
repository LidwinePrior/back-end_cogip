
# Cogip

Our mission is to create an API relating to an accounting app to cogip company.
[link api](https://api-cogip-329f9c72c66d.herokuapp.com/)

## Mission

Install all the dependances using composer
Confirm PHP (POO) and MVC Structure
CRUD
Validation & Sanitization (controllers)



## Tech Stack

**Server:** 
    - PHP

    - POO

    - MVC

    - Namespace

    - bramus router (A lightweight and simple - object oriented PHP Router)

    - filp/whoops: (PHP errors)

    - dragonbe/vies (tva validation)

    - firebase/php-jwt (authentification)



## API Reference

#### GET all companies

```http
  GET /api/companies
```

#### GET last five companies

```http
   GET /api/fivecompanies
```

#### GET company

```http
  GET /api/companies/${id}
```

#### POST company

```http
  POST /api/add-company
```

#### DELETE company

```http
  DELETE /api/del-company
```

#### PUT company

```http
  PUT /api/update-company
```



#### GET all contacts

```http
  GET /api/contacts
```

#### GET last five contacts

```http
   GET /api/fivecontacts
```

#### GET contact

```http
  GET /api/contcats/${id}
```

#### POST contact

```http
  POST /api/add-contact
```

#### DELETE contact

```http
  DELETE /api/del-contact
```

#### PUT contact

```http
  PUT /api/update-contact
```



#### GET all invoices

```http
  GET /api/invoices
```

#### GET last five invoices

```http
   GET /api/fiveinvoices
```

#### GET invoice

```http
  GET /api/invoices/${id}
```

#### POST invoice

```http
  POST /api/add-invoice
```

#### DELETE invoice

```http
  DELETE /api/del-invoice
```

#### PUT invoice

```http
  PUT /api/update-invoice
```


## Our roles

Lidwine:

    - method: get, post

    - sanitize & validation

    - put db online


Mathias:

    - method: delete

    - authentification

    - cors

Together:

    - router

    - method: put

    - deployment on heroku
## Authors

[Lidwine](https://www.github.com/LidwinePrior) & [Mathias](https://github.com/PAZTEK1007)


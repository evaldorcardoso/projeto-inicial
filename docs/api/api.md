# Projeto Inicial API

Esta é uma API para cadastrar e listar usuários e seus certificados

> ## Usuários

## Registrar um usuário [/api/register]

Registra um usuário no sistema. [POST]

+ Headers

        Accept: application/json


+ Body
    + name: `string`
    + email : `string`
    + password : `string`
    + password_confirmation : `string`
    + cpf : `string`
    + born_date : `string`
    + address : `string`

+ Response 200 (application/json)

    ```js
    {
        "user": {
            "name": "Teste App",
            "email": "teste2@teste.com.br",
            "cpf": "00000000002",
            "born_date": "2000-01-01",
            "address": "Rua teste de teste, 123",
            "phone_1": "51999999999",
            "phone_2": "51888888888",
            "updated_at": "2021-08-17T14:18:10.000000Z",
            "created_at": "2021-08-17T14:18:10.000000Z",
            "id": 2
        },
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZWNjOTFkMDVkNDk4MzM2OGNlOWJlYzQ0OWI3NzNhYjJlZDkxYmM3NmVjM2RkMWEzYTEyZDdjNTU0ZGRkNTNmYTY1OGI3MDA1NWY4NWEwMjkiLCJpYXQiOjE2MjkyMDk4OTAuNzg0ODYyLCJuYmYiOjE2MjkyMDk4OTAuNzg0ODY2LCJleHAiOjE2NjA3NDU4OTAuNzY3MjczLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0."
    } 
    ```


## Logar o usuário [/api/login]

Faz o login do usuário no sistema. [POST]

+ Headers

        Accept: application/json

+ Body
    + email: `string`
    + password: `string`

+ Response 200 (application/json)

    ``` js
    {
        "user": {
            "id": 1,
            "name": "Teste App",
            "email": "teste@teste.com.br",
            "email_verified_at": null,
            "cpf": "00000000001",
            "phone_1": null,
            "phone_2": null,
            "born_date": "2000-01-01",
            "address": "Rua teste de teste, 123",
            "created_at": "2021-08-16T19:29:56.000000Z",
            "updated_at": "2021-08-16T19:29:56.000000Z"
        },
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzFjYWJiMGEwZTRiMWNjN2Y3MDgyNzlkNTYwMjY0NDkwMmI1NWZmNzZhOTVhOWIyNjZlNTYxM2Q1ZDVhNGY1MTBjOTAzOTMyZTQwY2NlNTgiLCJpYXQiOjE2MjkyMTAwNzMuNjgzNjgxLCJuYmYiOjE2MjkyMTAwNzMuNjgzNjg0LCJleHAiOjE2NjA3NDYwNzMuNjczMTg1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0."
    }
    ```

## Logout de Usuário [/api/logout]

Desloga o usuário do sistema, revogando o seu token. [POST]

+ Headers

        Accept: application/json

+ Authorization
    + Token : `Bearer`

> ## Certificados

## Cadastrar um certificado [/api/certificates]

Cadastra um novo certificado para o Usuário logado. [POST]

+ Headers

        Accept: application/json

+ Authorization
    + Token : `Bearer`

+ Body
    + file : `file (.pem)`
    + expiration_date : `string`
    + dn : `string`
    + issuer_dn : `string`

+ Response 200 (application/json)

    ``` js
    {
        "success": true,
        "data": {
            "expiration_date": "2025-01-01",
            "dn": "lorem dn",
            "issuer_dn": "lorem issuer",
            "user_id": 1,
            "updated_at": "2021-08-17T14:24:10.000000Z",
            "created_at": "2021-08-17T14:24:10.000000Z",
            "id": 14
        }
    }
    ```

## Listar os certificados [/api/certificates]

Lista os certificados do Usuário logado. [GET]

+ Headers

        Accept: application/json

+ Authorization
    + Token : `Bearer`

+ Response 200 (application/json)

    ``` js
    {
        "success": true,
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "expiration_date": "2025-01-01",
                "dn": "lorem dn",
                "issuer_dn": "lorem issuer",
                "filename": "public/files/txtteste.pem",
                "created_at": "2021-08-16T19:34:50.000000Z",
                "updated_at": "2021-08-16T19:34:50.000000Z"
            }
        ]
    }
    ```

## Editar um certificado [/api/certificates/{id}]

Alterar os dados de um certificado. [POST]


+ Parameters
    + id: `integer`

+ Headers

        Accept: application/json

+ Authorization
    + Token : `Bearer`

+ Body
    + expiration_date : `string`
    + dn : `string`
    + issuer_dn : `string`

+ Response 200 (application/json)

    ``` js
    {
        "success": true
    }   
    ```

## Excluir um certificado [/api/certificates/{id}]

Excluir um certificado. [DELETE]


+ Parameters
    + id: `integer`

+ Headers

        Accept: application/json

+ Authorization
    + Token : `Bearer`

+ Response 200 (application/json)

    ``` js
    {
        "success": true
    }   
    ```    
## Exibir os dados de um certificado [/api/certificates/{id}]

Exibir os dados de um certificado. [GET]


+ Parameters
    + id: `integer`

+ Headers

        Accept: application/json

+ Authorization
    + Token : `Bearer`

+ Response 200 (application/json)

    ``` js
    {
        "success": 200,
        "data": {
            "id": 2,
            "user_id": 1,
            "expiration_date": "2024-01-01",
            "dn": "lorem ipsum",
            "issuer_dn": "lorem ipsum",
            "filename": "teste.pem",
            "created_at": "2021-08-16T19:35:26.000000Z",
            "updated_at": "2021-08-17T14:24:50.000000Z"
        }
    }
    ```

# Projeto Laravel 10 com PostgreSQL

Este projeto é uma aplicação Laravel 10 utilizando o PostgreSQL como banco de dados. Ele é configurado para rodar em containers Docker, facilitando a instalação e execução do ambiente de desenvolvimento.

## Pré-requisitos

- Docker
- Docker Compose

## Configuração do Ambiente

Clonar o repositório

        git clone git@github.com:fabiotmourao/api-places.git
        cd <NOME_DO_PROJETO>

## Configurar o arquivo .env

Copie o arquivo .env.example para .env e configure as variáveis de ambiente conforme necessário:

cp .env.example .env    

    DB_CONNECTION=pgsql
    DB_HOST=postgres
    DB_PORT=5432
    DB_DATABASE=api-places
    DB_USERNAME=root
    DB_PASSWORD=password
    FORWARD_DB_PORT=5432


## Iniciar os containers

Use o Laravel Sail para iniciar os containers:

    ./vendor/bin/sail up -d

## Gerar chave de aplicação

Gere uma chave de aplicação para Laravel:

    ./vendor/bin/sail artisan key:generate

## Executar migrações

Execute as migrações para criar as tabelas no banco de dados:
    
    ./vendor/bin/sail artisan migrate

#### Uso

Após configurar o ambiente, você pode acessar a aplicação Laravel no navegador:

URL da aplicação: http://localhost:8085

#### Usando Postman

No diretorio /docs a um arquivo Postman Collections:
    
#### Tests

Execute os testes de feature:
    
    ./vendor/bin/sail artisan test

### Estrutura do Projeto

laravel: Serviço principal da aplicação Laravel.
postgres: Serviço de banco de dados PostgreSQL.

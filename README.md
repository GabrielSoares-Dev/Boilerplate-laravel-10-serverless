# Laravel 10 Boilerplate with serverless framework

This Laravel 10 boilerplate provides a robust initial structure for web development, using Laravel version 10 and PHP 8.1. It includes various tools to enhance development efficiency, ensuring coding best practices, testing, and ease of deployment.

## Prerequisites

Before you begin, make sure you have the following tools installed in your development environment:

- docker


## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/GabrielSoares-Dev/Boilerplate-laravel-10-clean-architecture.git


2. **Start the container:**

   ```bash
   docker-compose -f docker-compose-dev.yml up -d

3. **Open the terminal in the docker to start the development server and run:**

   ```bash
   composer start:dev

## Commands

1. **Check Code style:**

   ```bash
   composer lint:test

2. **Fix Code style:**

   ```bash
   composer lint:fix

3. **Run tests:**

   ```bash
   composer test

4. **Run unit tests:**

   ```bash
   composer test:unit

5. **Run integration tests:**

   ```bash
   composer test:integration

6. **Run coverage**

   ```bash
   composer test:coverage


7. **Default commit:**

   ```bash
   npm run commit

7. **Prepare database:**

   ```bash
   php artisan db:prepare

## Docs

You can find the complete API documentation at the following Postman link:

[![Running on postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/12430293/2s9YkgC5De)

## By Gabriel Soares Maciel

# Laravel 10 Boilerplate

This Laravel 10 boilerplate provides a robust initial structure for web development, using Laravel version 10 and PHP 8.1. It includes various tools to enhance development efficiency, ensuring coding best practices, testing, and ease of deployment.

## Prerequisites

Before you begin, make sure you have the following tools installed in your development environment:

- docker
- composer


## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/GabrielSoares-Dev/Boilerplate-laravel-10.git


2. **Start the container:**

   ```bash
   docker-compose -f docker-compose-dev.yml up -d

3. **Open the terminal in the docker to start the development server and run:**

   ```bash
   composer start:dev

## Commands

1. **Code style:**

   ```bash
   composer lint

2. **Run unit tests:**

   ```bash
   composer test:unit
2. **Run integration tests:**

   ```bash
   composer test:integration

3. **Run coverage**

   ```bash
   composer test:coverage


4. **Default commit:**

   ```bash
   npm run commit

## By Gabriel Soares Maciel
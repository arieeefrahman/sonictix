# SonicTIX : Event Ticket Booking Website

Welcome to SonicTIX! This repository contains the code for an online platform where users can browse and book tickets for various events. The system is built using PostgreSQL, PHP Laravel, HTML, CSS, JavaScript, and Redis.

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
## Introduction
The Event Ticket Booking System is designed to simplify the process of browsing and purchasing event tickets online. Users can view event details, select ticket categories, and complete their bookings with ease. This system aims to provide a seamless experience for both event organizers and attendees.

## Features

- **Event Listings:** Browse a wide range of events with detailed descriptions and images.
- **Ticket Category Selection:** Choose preferred ticket categories.
- **Booking Management:** View and manage your bookings.
- **User Authentication:** Secure login and registration for users.

## Technologies Used

- **Backend:**
  - PHP Laravel
  - PostgreSQL
  - Redis

- **Frontend:**
  - HTML
  - CSS
  - JavaScript

## Installation
### Prerequisites

- PHP >= 7.3
- Composer
- PostgreSQL
- Redis
- Node.js & npm

### Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/arieeefrahman/sonictix.git
   cd sonictix
   ````

2. **Install dependencies:**
    ```bash
    composer install
    npm install
    ````
3. **Set up the environment file:**
    ```bash
    cp .env.example .env
    ```

4. **Configure the environment variables in .env file:**

    Set up your database and Redis connection details.
    ```
    APP_NAME=
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=
    APP_URL=

    DB_CONNECTION=
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

    JWT_SECRET=
    ```

5. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

6. **Run database migrations and seed the database:**
    ```bash
    php artisan migrate --seed
    ```
7. **Start the server:**
    ```bash
    php artisan serve
    ```

## Usage
To start using the Event Ticket Booking System, navigate to http://localhost:8000 in your web browser or check the url in your terminal.

For Users: Register or log in to your account, browse events, select your ticket categories, and book your tickets.
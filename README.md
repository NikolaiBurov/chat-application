# Chat Application

This repository contains the code for Laravel, a chat application built with Laravel framework. It utilizes Docker,
PostgreSQL, and Pusher to provide a real-time messaging experience.

## Prerequisites

- Docker
- Docker Compose
- Node.js
- PHP (>= 7.4)
- Composer

## Docker Setup

1. docker compose build
2. docker-compose up -d

## Installation

1. Clone the repository:
   git clone <repository_url>

2. Navigate to the project directory:
   cd chat-application

3. Log into the docker container 

4. Create a copy of the `.env.example` file and name it `.env`:
   cp .env.example .env

5. Install PHP dependencies:
   composer install 

6. Install JavaScript dependencies:
   npm install 

7. Run migrations:
   php arisan migrate

   
## Usage

You can now access the chat application by visiting `http://chat.localhost/` in your web browser.

You must start the workers within the container by : php artisan queue:work

## Additional Information

- The PostgreSQL database is configured to use the `postgres` container as the host.
- Pusher credentials can be configured in the `.env` file. Make sure to update the `PUSHER_APP_KEY`, `PUSHER_APP_CLUSTER`, `PUSHER_APP_SECRET` and `PUSHER_APP_ID` variables accordingly.

## Support

If you encounter any issues or have any questions, please [open an issue](<repository_url>/issues) in this repository.

## License

This project is licensed under the [MIT License](LICENSE).

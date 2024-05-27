# Battle Of Stalingrad Simulation

Welcome to Battle Of Stalingrad Simulation, a turn-based strategy game where you engage in thrilling tank combat! This project is part of a take-home test and showcases a PHP backend built with Laravel and a JavaScript frontend.

## Features

- Engage in turn-based tank combat.
- Explore dynamic maps with obstacles and open spaces.
- Battle against AI or other players.

## Installation

To set up the project using Docker, follow these steps:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/andresj-sanchez/battle-of-stalingrad-game.git

2. **Navigate to the project directory:**

    ```bash
    cd battle-of-stalingrad-game

3. **Build and start the Docker containers:**

    ```bash
    docker-compose up -d --build
    
Note: The build process may take some time, especially due to the Couchbase library installation.

4. **Set up environment variables:**

Create a copy of the .env.example file and rename it to .env. Update the database and other environment variables as needed.

5. **Access Couchbase:**

Open your web browser and navigate to http://localhost:8091/ui/index.html to access the Couchbase web interface.

6. **Access the application:**

Open your web browser and navigate to http://localhost:8080 to access the application.

7. **Access the API documentation:**

Open your web browser and navigate to http://localhost:8080/swagger/docs to access the API documentation.
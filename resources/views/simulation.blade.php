<!DOCTYPE html>
<html>
<head>
    <title>Game Simulation</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            /* overflow: hidden; */
        }
        
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('uploads/images/battle-of-stalingrad-background.jpg') }}");
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            opacity: 0.8; /* Adjust the opacity here */
            z-index: -1;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat({{ count($mapData['grid'][0]) }}, 15px);
            grid-template-rows: repeat({{ count($mapData['grid']) }}, 15px);
        }
        .cell {
            width: 15px;
            height: 15px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .tank {
            background-color: #007bff;
            color: white;
        }
        .path {
            background-color: #ffcc00;
        }
        .attack {
            background-color: red;
        }
        .obstacle {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Game Simulation</h1>
        <div>Turn Number: <span id="turn-number">0</span></div>
        <div id="player-info"></div>
        <div class="grid" id="game-grid">
            <!-- Grid cells will be populated by JavaScript -->
        </div>
        <button class="btn btn-primary" id="start-simulation">Start Simulation</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const gameData = {{ Js::from($gameSessionArray) }};
        const mapData = {{ Js::from($mapData) }};
        const grid = document.getElementById('game-grid');
        const turnNumberDisplay = document.getElementById('turn-number');
        const playerInfoDisplay = document.getElementById('player-info');

        // Initialize grid based on mapData
        mapData.grid.forEach(row => {
            row.forEach(cellValue => {
                const cell = document.createElement('div');
                cell.classList.add('cell');
                if (cellValue === 10) {
                    cell.classList.add('obstacle');
                }
                grid.appendChild(cell);
            });
        });

        const renderPlayerInfo = (players) => {
            playerInfoDisplay.innerHTML = players.map(player => `
                <div>
                    ${player.name} (${player.tank.type}): <span id="${player.tank.id}-health">${player.tank.health_points}</span> HP
                </div>
            `).join('');
        };

        const updatePlayerHealth = (tankStates) => {
            tankStates.forEach(tank => {
                document.getElementById(`${tank.id}-health`).innerText = tank.healthPoints;
            });
        };

        const renderTanks = (tankStates) => {
            // Clear previous tanks and paths
            document.querySelectorAll('.tank').forEach(el => {
                el.classList.remove('tank');
                el.innerText = '';
            });
            document.querySelectorAll('.path').forEach(el => el.classList.remove('path'));

            // Render new tank positions
            tankStates.forEach(tank => {
                const index = tank.y * mapData.grid[0].length + tank.x;
                grid.children[index].classList.add('tank');
                grid.children[index].innerText = tank.type[0]; // Display first letter of tank type
            });
        };

        const renderPath = (path) => {
            path.forEach(step => {
                const index = step.y * mapData.grid[0].length + step.x;
                grid.children[index].classList.add('path');
            });
        };

        const initTanksStartPosition = (players) => {
            const initialTankStates = players.map(player => ({
                id: player.tank.id,
                type: player.tank.type,
                x: player.tank.x,
                y: player.tank.y,
                healthPoints: player.tank.health_points
            }));
            renderTanks(initialTankStates);
        };

        const simulateTurn = (turnData) => {
            turnNumberDisplay.innerText = turnData.turnNumber;

            turnData.actions.forEach(action => {
                if (action.action === "move" && action.steps) {
                    renderPath(action.steps);
                }
            });

            setTimeout(() => {
                renderTanks(turnData.tankStates);
                updatePlayerHealth(turnData.tankStates);
            }, 1000);
        };

        document.getElementById('start-simulation').addEventListener('click', () => {
            // Display player info once at the start
            renderPlayerInfo(gameData.players);
            initTanksStartPosition(gameData.players);

            let turn = 0;
            const interval = setInterval(() => {
                if (turn >= gameData.turn_logs.length) {
                    clearInterval(interval);
                    return;
                }
                simulateTurn(gameData.turn_logs[turn]);
                turn++;
            }, 2000);
        });
    </script>
</body>
</html>

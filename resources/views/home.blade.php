<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Battle of Stalingrad</title>
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

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Optional background for content */
            border-radius: 10px;
            text-align: center; /* Center align text inside the container */
        }


        .btn {
            margin: 10px; /* Add margin between buttons */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Battle of Stalingrad</h1>
        <a href="{{ route('leaderboard') }}" class="btn btn-primary">Global Leaderboards</a>
        <a href="{{ route('selection-menu') }}" class="btn btn-primary">Play the Game</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
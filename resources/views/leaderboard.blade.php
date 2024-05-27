<!-- resources/views/leaderboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Global Leaderboards</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Global Leaderboards</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboards as $leaderboard)
                <tr>
                    <td>{{ $leaderboard->player_id }}</td>
                    <td>{{ $leaderboard->top_score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

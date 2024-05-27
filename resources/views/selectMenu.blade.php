<!-- resources/views/selectTank.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Select Tank and Map</title>
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
        <h1>Select Your Tank and Map</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('simulate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="tank1">Select Tank 1:</label>
                <select name="tanks[]" class="form-control" id="tank1">
                    @foreach ($tanks as $tank)
                    <option value="{{ $tank['id'] }}">{{ $tank['type'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tank2">Select Tank 2:</label>
                <select name="tanks[]" class="form-control" id="tank2">
                    @foreach ($tanks as $tank)
                    <option value="{{ $tank['id'] }}">{{ $tank['type'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="map">Select Map:</label>
                <select name="map_id" class="form-control" id="map">
                    @foreach ($maps as $map)
                    <option value="{{ $map['id'] }}">{{ $map['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Start Simulation</button>
        </form>
        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

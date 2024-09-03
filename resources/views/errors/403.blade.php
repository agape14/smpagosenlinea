<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .forbidden-container {
            text-align: center;
        }
        .forbidden-container h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }
        .forbidden-container p {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .forbidden-container a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.2em;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .forbidden-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="forbidden-container">
        <h1>403 Forbidden</h1>
        <p>No tienes permiso para acceder a esta página</p>
        <a href="{{ url('/login') }}">Regresar al inicio</a>
    </div>
</body>
</html>
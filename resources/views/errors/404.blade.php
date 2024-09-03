<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
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
        .not-found-container {
            text-align: center;
        }
        .not-found-container img {
            max-width: 100%; /* La imagen ocupará todo el ancho disponible */
            height: auto;
            max-height: 80vh; /* La imagen ocupará hasta el 80% de la altura de la ventana */
            object-fit: contain; /* Mantiene la proporción de la imagen */
        }
        .not-found-container h1 {
            margin-top: 20px;
            font-size: 2.5em;
        }
        .not-found-container p {
            font-size: 1.2em;
            margin-top: 10px;
        }
        .not-found-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1.2em;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .not-found-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="not-found-container">
        <img src="{{ asset('images/not-found.svg') }}" alt="Not Found">
        <h1>Oops! Page Not Found</h1>
        <p></p>
        <a href="{{ url('/admin/dashboard') }}">Regresar al inicio</a>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 419 - Expiración de Página</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Flexbox centering */
        .container {
            height: 100vh; /* Full viewport height */
            display: flex;
            align-items: center; /* Vertical centering */
            justify-content: center; /* Horizontal centering */
            text-align: center;
        }
        .message {
            max-width: 600px;
        }
        .message img {
            max-width: 300px; /* Adjust based on your image size */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <img src="{{ asset('images/session-expired.svg') }}" alt="Session Expired">
            <h1 class="display-4">Sesión Expirada</h1>
            <p class="lead">Tu sesión ha expirado. Por favor, vuelve a iniciar sesión para continuar.</p>
            <a href="{{ route('login') }}" class="btn btn-success">Iniciar Sesión</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

blade.php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }
        .error-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 50px 20px;
        }
        .error-code {
            font-size: 10rem;
            font-weight: bold;
            color: #e10600; /* F1 red */
            margin: 0;
            line-height: 1;
        }
        .checkered-border {
            background: repeating-linear-gradient(45deg, #000, #000 20px, #fff 20px, #fff 40px);
            height: 15px;
            margin: 20px 0;
        }
        .error-image {
            max-width: 100%;
            height: auto;
            margin: 30px 0;
        }
        .home-button {
            display: inline-block;
            background-color: #e10600;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #b30500;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="checkered-border"></div>
        <h1 class="error-code">404</h1>
        <h2>¡Bandera roja! La página no existe</h2>
        <p>Parece que has tomado una curva equivocada. La página que buscas no se encuentra en nuestro circuito.</p>
        
        <p>No te preocupes, no necesitas el Safety Car. Simplemente regresa a la parrilla de salida.</p>
        
        <a href="{{ route('dashboard') }}" class="home-button">Volver al inicio</a>
        <div class="checkered-border"></div>
    </div>
</body>
</html>
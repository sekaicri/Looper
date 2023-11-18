<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Looper - Generador de Códigos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100vh;
        }

        header {
            background-color: #008CBA;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            width: 100%;
        }

        .container {
            display: flex;
            justify-content: space-around;
            width: 80%;
            max-width: 800px;
        }

        .codes-container,
        .tournament-container {
            width: 45%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 15px;
            background-color: #dff0d8;
            padding: 15px;
            border-radius: 8px;
        }

        .download-button {
            background-color: #008CBA;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        Looper - Generador de Códigos
    </header>

    <div class="container">
        <div class="codes-container">
            <form action="{{ url('/generate-codes') }}" method="post">
                @csrf
                <label for="quantity">Cantidad:</label>
                <input type="number" name="quantity" value="1" required>
                <label for="value">Valor:</label>
                <input type="number" name="value" value="5" required>
                <br>
                <input type="hidden" name="generated_codes" value="{{ implode(',', $codes) }}">
                <br>
                <button type="submit">Generar Códigos</button>
            </form>

            @if (!empty($codes))
                <h1>Códigos Generados:</h1>
                <ul>
                    @foreach ($codes as $code)
                        <li>{{ $code }}</li>
                    @endforeach
                </ul>
                <!-- Botón para descargar los códigos -->
                <form action="{{ url('/download-codes') }}" method="get">
                    @csrf
                    <input type="hidden" name="codes" value="{{ implode(',', $codes) }}">
                    <button class="download-button" type="submit">Descargar Códigos</button>
                </form>
            @endif
        </div>

        <!-- Lista de Torneo -->
        <div class="tournament-container">
            <h1>Torneo</h1>
            <ul>
                @if (isset($tournamentRecords))
                    @foreach ($tournamentRecords as $record)
                        <li>
                            <strong>Usuario:</strong> {{ $record['name_user'] }}<br>
                            <strong>Puntuación:</strong> {{ $record['score'] }}<br>
                            <strong>Código:</strong> {{ $record['code'] }}<br>
                            <strong>Pagado:</strong> {{ $record['is_code_paid'] ? 'Sí' : 'No' }}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    
</body>
</html>
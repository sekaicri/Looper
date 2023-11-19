<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Looper - Generador de Códigos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding-top: 50px; /* Añadido espacio para el header fijo */
        }

        header {
            background-color: #008CBA;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .container {
            margin-top: 80px; /* Añadido espacio para el header fijo */
        }

        .codes-container,
        .tournament-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .codes-container {
            max-width: 400px;
        }

        .tournament-container {
            max-width: 600px;
        }

        .download-button,
        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .tournament-list {
            padding: 0;
        }

        .tournament-item {
            list-style-type: none;
            background-color: #dff0d8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        Looper - Generador de Códigos
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="codes-container">
                    <form action="{{ url('/generate-codes') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="quantity">Cantidad:</label>
                            <input type="number" class="form-control" name="quantity" value="1" required>
                        </div>
                        <div class="form-group">
                            <label for="value">Valor:</label>
                            <input type="number" class="form-control" name="value" value="5" required>
                        </div>
                        <input type="hidden" name="generated_codes" value="{{ implode(',', $codes) }}">
                        <button type="submit" class="btn btn-primary">Generar Códigos</button>
                    </form>

                    @if (!empty($codes))
                        <h2>Códigos Generados:</h2>
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
            </div>

            <div class="col-md-6">
                <!-- Lista de Torneo -->
                <div class="tournament-container">
                    <h2>Looper Tournament</h2>
                    <ul class="tournament-list">
                        @foreach ($tournamentRecords as $record)
                            <li class="tournament-item">
                                <strong>Usuario:</strong> {{ $record['name_user'] }}<br>
                                <strong>Ganancia:</strong> {{ $record['score'] }}$<br>
                                <strong>Código:</strong> {{ $record['code'] }}<br>
                                <strong>Pagado:</strong> {{ $record['is_code_paid'] ? 'Sí' : 'No' }}
                
                                @if (!$record['is_code_paid'])
                                    <form action="{{ url('/mark-code-as-paidB') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="code" value="{{ $record['code'] }}">
                                        <button type="submit" class="btn btn-success">Pagar</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
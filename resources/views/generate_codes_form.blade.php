<!-- resources/views/generate_codes_form.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Códigos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
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
            margin-bottom: 5px;
            background-color: #dff0d8;
            padding: 8px;
            border-radius: 4px;
        }

        /* Botón para descargar códigos */
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
    <div class="container">
        <form action="{{ url('/generate-codes') }}" method="post">
            @csrf
            <label for="quantity">Cantidad:</label>
            <input type="number" name="quantity" value="1" required>
            <br>
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
</body>
</html>
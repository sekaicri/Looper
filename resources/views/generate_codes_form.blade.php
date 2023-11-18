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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            margin-top: 20px;
            font-size: 18px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <form action="{{ url('/generate-codes') }}" method="post">
        @csrf
        <label for="quantity">Cantidad:</label>
        <input type="number" name="quantity" value="1" required>
        <br>
        <label for="value">Valor:</label>
        <input type="number" name="value" value="5" required>
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
    @endif
</body>
</html>
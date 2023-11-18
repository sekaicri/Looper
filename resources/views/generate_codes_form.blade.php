<!-- resources/views/generate_codes_form.blade.php -->
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
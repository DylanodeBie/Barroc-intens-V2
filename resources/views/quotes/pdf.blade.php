<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offerte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px;
        }

        .header {
            text-align: center;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .details,
        .summary {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="title">OFFERTE</h1>
        </div>

        <div class="details">
            <p><strong>Bedrijfsnaam:</strong> {{ $quote->customer->company_name }}</p>
            <p><strong>Klantnr.:</strong> {{ $quote->customer->id }}</p>
            <p><strong>Periode:</strong> {{ now()->format('F Y') }}</p>
            <p><strong>Factuurnr.:</strong> {{ $quote->id }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Aantal</th>
                    <th>Nummer</th>
                    <th>Omschrijving</th>
                    <th>Prijs</th>
                    <th>Subtotaal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quote->machines as $machine)
                    <tr>
                        <td>{{ $machine->pivot->quantity }}</td>
                        <td>{{ $machine->id }}</td>
                        <td>{{ $machine->name }}</td>
                        <td>€{{ number_format($machine->lease_price, 2, ',', '.') }}</td>
                        <td>€{{ number_format($machine->lease_price * $machine->pivot->quantity, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @foreach ($quote->beans as $bean)
                    <tr>
                        <td>{{ $bean->pivot->quantity }}</td>
                        <td>{{ $bean->id }}</td>
                        <td>{{ $bean->name }}</td>
                        <td>€{{ number_format($bean->price, 2, ',', '.') }}</td>
                        <td>€{{ number_format($bean->price * $bean->pivot->quantity, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p class="total"><strong>Totaal:</strong>
                €{{ number_format(
                    $quote->machines->sum(fn($machine) => $machine->pivot->quantity * $machine->lease_price) +
                        $quote->beans->sum(fn($bean) => $bean->pivot->quantity * $bean->price),
                    2,
                    ',',
                    '.',
                ) }}
            </p>
        </div>

        <div class="footer">
            <p>Te betalen binnen 14 dagen na dagtekening.</p>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Factuur {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        h1,
        h2,
        p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>Factuur: {{ $invoice->invoice_number }}</h1>
    <p><strong>Klant:</strong> {{ $invoice->customer->company_name }}</p>
    <p><strong>Datum:</strong> {{ $invoice->invoice_date->format('d-m-Y') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>

    <h2>Items</h2>
    <table>
        <thead>
            <tr>
                <th>Omschrijving</th>
                <th>Aantal</th>
                <th>Prijs per stuk</th>
                <th>Subtotaal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>€{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td>€{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Totaal:</strong></td>
                <td><strong>€{{ number_format($invoice->total_amount, 2, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>

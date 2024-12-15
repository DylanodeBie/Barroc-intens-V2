<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Factuur {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            line-height: 1.5;
        }

        .container {
            margin: 40px;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header .customer-info {
            font-size: 12px;
        }

        .header .logo {
            text-align: right;
        }

        .header .logo img {
            width: 100px;
        }

        .info-table {
            margin-top: 20px;
            font-size: 12px;
        }

        .info-table td {
            padding: 2px 0;
        }

        .line {
            height: 2px;
            background-color: #FFD700;
            margin: 20px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        .items-table th,
        .items-table td {
            border: none;
            text-align: left;
            padding: 8px;
        }

        .items-table th {
            font-style: italic;
            color: #444;
            font-weight: bold;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total {
            margin-top: 20px;
            font-size: 12px;
            text-align: right;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-style: italic;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="customer-info">
                <h1>FACTUUR</h1>
                <p>
                    <strong>Prof. {{ $invoice->customer->name }}</strong><br>
                    {{ $invoice->customer->address }}<br>
                    {{ $invoice->customer->postal_code }} {{ $invoice->customer->city }}
                </p>
            </div>
            <div class="logo">
                <img src="{{ public_path('img/Logo1_klein.png') }}" alt="Logo">
                <p>Barroc Intens<br>Terheijdenseweg 350<br>4826 AA Breda</p>
            </div>
        </div>

        <!-- Invoice Information -->
        <table class="info-table">
            <tr>
                <td><strong>Periode:</strong></td>
                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Klantnr.:</strong></td>
                <td>{{ $invoice->customer->id }}</td>
            </tr>
            <tr>
                <td><strong>Contractnr.:</strong></td>
                <td>6</td>
            </tr>
            <tr>
                <td><strong>Factuurnr.:</strong></td>
                <td>{{ $invoice->invoice_number }}</td>
            </tr>
        </table>

        <!-- Divider -->
        <div class="line"></div>

        <!-- Items Table -->
        <table class="items-table">
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
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->quantity }}x</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->description }}</td>
                        <td>€{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td>€{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div class="total">
            <p>Totaal: €{{ number_format($invoice->total_amount, 2, ',', '.') }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Te betalen binnen 14 dagen na dagtekening.</p>
        </div>
    </div>
</body>

</html>

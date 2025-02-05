<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Leasecontract #{{ $leasecontract->id }}</title>
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
            font-size: 14px;
            line-height: 1.6;
        }

        .header .logo {
            text-align: right;
        }

        .header .logo img {
            width: 120px;
        }

        .info-table {
            width: 100%;
            margin-top: 20px;
            font-size: 14px;
            border-spacing: 0;
        }

        .info-table td {
            padding: 4px 0;
        }

        .line {
            height: 4px;
            background-color: #FFD700;
            margin: 20px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        .items-table th {
            background-color: #FFD700;
            font-weight: bold;
            text-align: center;
        }

        /* Hier wordt de prijs- en subtotaal kolommen naar rechts uitgelijnd */
        .items-table .price,
        .items-table .subtotal {
            text-align: right;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
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
        <div class="header">
            <div class="customer-info">
                <h1>Leasecontract #{{ $leasecontract->id }}</h1>
                <p>
                    <strong>Klant:</strong> {{ $leasecontract->customers->company_name }}<br>
                    <strong>Gebruiker:</strong> {{ $leasecontract->users->name }}<br>
                    <strong>Status:</strong> {{ ucfirst($leasecontract->status) }}
                </p>
            </div>
            <div class="logo">
                <img src="{{ public_path('img/Logo1_klein.png') }}" alt="Logo">
                <p>Barroc Intens<br>Terheijdenseweg 350<br>4826 AA Breda</p>
            </div>
        </div>

        <table class="info-table">
            <tr>
                <td><strong>Startdatum:</strong></td>
                <td>{{ \Carbon\Carbon::parse($leasecontract->start_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td><strong>Einddatum:</strong></td>
                <td>{{ \Carbon\Carbon::parse($leasecontract->end_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td><strong>Betalingsoptie:</strong></td>
                <td>{{ ucfirst($leasecontract->payment_method) }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th class="price">Prijs</th>
                    <th>Aantal</th>
                    <th class="subtotal">Subtotaal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leasecontract->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="price">€{{ number_format($product->pivot->price, 2, ',', '.') }}</td>
                    <td>{{ $product->pivot->amount }}x</td>
                    <td class="subtotal">€{{ number_format($product->pivot->price * $product->pivot->amount, 2, ',', '.') }}</td>
                </tr>
                @endforeach

                <tr>
                    @php
                    $total_price = $leasecontract->products->sum(function($product) {
                        return $product->pivot->price * $product->pivot->amount;
                    });
                    @endphp
                    <td colspan="3"><strong>Totaal:</strong></td>
                    <td class="subtotal"><strong>€{{ number_format($total_price, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Dit contract is opgesteld: {{ \Carbon\Carbon::parse($leasecontract->created_at)->format('d-m-Y') }} en is dus geldig tot: {{ \Carbon\Carbon::parse($leasecontract->end_date)->format('d-m-Y') }}</p>
            <p>Contractvoorwaarden en meer informatie zijn beschikbaar bij Barroc Intens. Neem contact met ons op voor vragen of wijzigingen.</p>
            <p><strong>Handtekening:</strong></p>
            <div style="border: 1px solid #000; width: 300px; height: 100px; margin-top: 10px;"></div>
            <p>Datum: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        </div>
    </div>x
</body>

</html>
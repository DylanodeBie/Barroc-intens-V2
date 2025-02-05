<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Factuur {{ $invoice->invoice_number }}</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; color: #000; line-height: 1.5;">
    <div style="margin: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="font-size: 12px;">
                <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">FACTUUR</h1>
                <p>
                    <strong>Prof. {{ $invoice->customer->name }}</strong><br>
                    {{ $invoice->customer->address }}<br>
                    {{ $invoice->customer->postal_code }} {{ $invoice->customer->city }}
                </p>
            </div>
            <div style="text-align: right;">
                <img src="{{ public_path('img/Logo1_klein.png') }}" alt="Logo" style="width: 100px;">
                <p>Barroc Intens<br>Terheijdenseweg 350<br>4826 AA Breda</p>
            </div>
        </div>

        <table style="margin-top: 20px; font-size: 12px;">
            <tr>
                <td style="padding: 2px 0;"><strong>Periode:</strong></td>
                <td style="padding: 2px 0;">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('F Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;"><strong>Klantnr.:</strong></td>
                <td style="padding: 2px 0;">{{ $invoice->customer->id }}</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;"><strong>Contractnr.:</strong></td>
                <td style="padding: 2px 0;">6</td>
            </tr>
            <tr>
                <td style="padding: 2px 0;"><strong>Factuurnr.:</strong></td>
                <td style="padding: 2px 0;">{{ $invoice->invoice_number }}</td>
            </tr>
        </table>

        <div style="height: 2px; background-color: #FFD700; margin: 20px 0;"></div>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 8px; font-style: italic; color: #444; font-weight: bold;">
                        Aantal</th>
                    <th style="text-align: left; padding: 8px; font-style: italic; color: #444; font-weight: bold;">
                        Nummer</th>
                    <th style="text-align: left; padding: 8px; font-style: italic; color: #444; font-weight: bold;">
                        Omschrijving</th>
                    <th style="text-align: right; padding: 8px; font-style: italic; color: #444; font-weight: bold;">
                        Prijs</th>
                    <th style="text-align: right; padding: 8px; font-style: italic; color: #444; font-weight: bold;">
                        Subtotaal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr style="background-color: {{ $loop->index % 2 === 0 ? '#f9f9f9' : 'transparent' }};">
                        <td style="padding: 8px;">{{ $item->quantity }}x</td>
                        <td style="padding: 8px;">{{ $item->id }}</td>
                        <td style="padding: 8px;">{{ $item->description }}</td>
                        <td style="padding: 8px; text-align: right;">€{{ number_format($item->unit_price, 2, ',', '.') }}
                        </td>
                        <td style="padding: 8px; text-align: right;">€{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; font-size: 12px; text-align: right; font-weight: bold;">
            <p>Totaal: €{{ number_format($invoice->total_amount, 2, ',', '.') }}</p>
        </div>

        <div style="margin-top: 40px; font-style: italic; font-size: 12px;">
            <p>Te betalen binnen 14 dagen na dagtekening.</p>
        </div>
    </div>
</body>

</html>

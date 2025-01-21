<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offerte</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; color: #000; line-height: 1.5;">
    <div style="margin: 40px;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="font-size: 12px;">
                <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">OFFERTE</h1>
                <p>
                    <strong>Bedrijfsnaam:</strong> {{ $quote->customer->company_name }}<br>
                    <strong>Klantnr.:</strong> {{ $quote->customer->id }}<br>
                    <strong>Periode:</strong> {{ now()->format('F Y') }}<br>
                    <strong>Offertenr.:</strong> {{ $quote->id }}
                </p>
            </div>
            <div style="text-align: right;">
                <img src="{{ public_path('img/Logo1_klein.png') }}" alt="Logo" style="width: 100px;">
                <p>Barroc Intens<br>Terheijdenseweg 350<br>4826 AA Breda</p>
            </div>
        </div>

        <!-- Divider -->
        <div style="height: 2px; background-color: #FFD700; margin: 20px 0;"></div>

        <!-- Items Table -->
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
                @foreach ($quote->machines as $machine)
                    <tr style="background-color: {{ $loop->index % 2 === 0 ? '#f9f9f9' : 'transparent' }};">
                        <td style="padding: 8px;">{{ $machine->pivot->quantity }}</td>
                        <td style="padding: 8px;">{{ $machine->id }}</td>
                        <td style="padding: 8px;">{{ $machine->name }}</td>
                        <td style="padding: 8px; text-align: right;">
                            €{{ number_format($machine->lease_price, 2, ',', '.') }}</td>
                        <td style="padding: 8px; text-align: right;">
                            €{{ number_format($machine->lease_price * $machine->pivot->quantity, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @foreach ($quote->beans as $bean)
                    <tr style="background-color: {{ $loop->index % 2 === 0 ? '#f9f9f9' : 'transparent' }};">
                        <td style="padding: 8px;">{{ $bean->pivot->quantity }}</td>
                        <td style="padding: 8px;">{{ $bean->id }}</td>
                        <td style="padding: 8px;">{{ $bean->name }}</td>
                        <td style="padding: 8px; text-align: right;">€{{ number_format($bean->price, 2, ',', '.') }}</td>
                        <td style="padding: 8px; text-align: right;">
                            €{{ number_format($bean->price * $bean->pivot->quantity, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div style="margin-top: 20px; font-size: 12px; text-align: right; font-weight: bold;">
            <p>Totaal: €{{ number_format(
    $quote->machines->sum(fn($machine) => $machine->pivot->quantity * $machine->lease_price) +
    $quote->beans->sum(fn($bean) => $bean->pivot->quantity * $bean->price),
    2,
    ',',
    '.',
) }}</p>
        </div>

        <!-- Footer -->
        <div style="margin-top: 40px; font-style: italic; font-size: 12px;">
            <p>Indien akkoord graag tekenen en terug sturen.</p>
        </div>
    </div>
</body>

</html>

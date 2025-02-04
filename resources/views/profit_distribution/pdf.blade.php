<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winstverdeling - {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 5px;
            color: #000;
        }

        h2 {
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #FFD700;
            color: black;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .profit-positive {
            color: green;
            font-weight: bold;
        }

        .profit-negative {
            color: red;
            font-weight: bold;
        }

        tfoot th {
            background-color: #FFD700;
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Winstverdeling - {{ $year }}</h1>
    <h2>Bedrijf: {{ $companyName }}</h2>

    <table>
        <thead>
            <tr>
                <th>Maand</th>
                <th>Inkomsten (€)</th>
                <th>Uitgaven (€)</th>
                <th>Winst (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monthlyData as $data)
                        @php
                            $profit = $data['income'] - $data['expenses'];
                            $profitClass = $profit < 0 ? 'profit-negative' : 'profit-positive';
                        @endphp
                        <tr>
                            <td>{{ $data['month'] }}</td>
                            <td class="text-right">€{{ number_format($data['income'], 2, ',', '.') }}</td>
                            <td class="text-right">€{{ number_format($data['expenses'], 2, ',', '.') }}</td>
                            <td class="text-right {{ $profitClass }}">€{{ number_format($profit, 2, ',', '.') }}</td>
                        </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                $totalProfit = $totalIncome - $totalExpenses;
                $totalProfitClass = $totalProfit < 0 ? 'profit-negative' : 'profit-positive';
            @endphp
            <tr>
                <th>Totaal</th>
                <th class="text-right">€{{ number_format($totalIncome, 2, ',', '.') }}</th>
                <th class="text-right">€{{ number_format($totalExpenses, 2, ',', '.') }}</th>
                <th class="text-right {{ $totalProfitClass }}">€{{ number_format($totalProfit, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>

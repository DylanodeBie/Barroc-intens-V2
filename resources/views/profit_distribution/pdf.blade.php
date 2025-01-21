<!DOCTYPE html>
<html>

<head>
    <title>Profit Distribution Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Profit Distribution Report</h1>
    <p><strong>Year:</strong> {{ $year }}</p>
    <p><strong>Total Income:</strong> €{{ number_format($totalIncome, 2) }}</p>

    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Customer ID</th>
                <th>Invoice Number</th>
                <th>Total Amount</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->customer_id }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>€{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Profit Distribution</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('profit_distribution.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="year" class="form-label">Year:</label>
                <select name="year" id="year" class="form-select">
                    @for($y = date('Y'); $y >= 2015; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="customer_id" class="form-label">Customer:</label>
                <select name="customer_id" id="customer_id" class="form-select">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Current Month Summary -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h2>Current Month: {{ now()->format('F Y') }}</h2>
                <p><strong>Income:</strong> €{{ number_format($currentMonthIncome, 2) }}</p>
                <p><strong>Expenses:</strong> €{{ number_format($currentMonthExpenses, 2) }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h2>Year: {{ $year }}</h2>
                <p><strong>Income:</strong> €{{ number_format($totalIncome, 2) }}</p>
                <p><strong>Expenses:</strong> €{{ number_format($totalExpenses, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <h3>Monthly Income</h3>
            <canvas id="incomeChart" height="200"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <h3>Monthly Expenses</h3>
            <canvas id="expenseChart" height="200"></canvas>
        </div>
    </div>

    <!-- Export Button -->
    <div class="text-end">
        <a href="{{ route('profit_distribution.export', ['year' => $year, 'customer_id' => $customerId]) }}"
            class="btn btn-success">
            Export to Excel
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/charts.js') }}"></script>
<script>
    // Data from backend (dynamically injected)
    const monthlyIncome = @json($monthlyIncome);
    const monthlyExpenses = @json($monthlyExpenses);
    const labels = @json($months); // Example: ['January', 'February', ...]

    // Render the income chart
    createBarChart('incomeChart', labels, monthlyIncome, 'Income per Month');

    // Render the expenses chart
    createBarChart('expenseChart', labels, monthlyExpenses, 'Expenses per Month');
</script>
@endsection

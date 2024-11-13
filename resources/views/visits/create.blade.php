@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Schedule a Maintenance Visit</h1>

        <form action="{{ route('visits.store') }}" method="POST">
            @csrf
            <!-- Customer Selection -->
            <div class="mb-6">
                <label for="customer_id" class="block text-gray-700">Customer</label>
                <select name="customer_id" class="w-full px-4 py-2 border rounded-md border-gray-300">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Visit Date Field -->
            <div class="mb-6">
                <label for="visit_date" class="block text-gray-700">Visit Date</label>
                <input type="date" name="visit_date" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
            </div>

            <!-- Other form fields -->

            <div class="mt-8 flex justify-between">
                <a href="{{ route('visits.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-md">Cancel</a>
                <button type="submit"
                    class="bg-yellow-400 text-black px-6 py-2 rounded-md hover:bg-yellow-500">Save</button>
            </div>
        </form>
    </div>
@endsection

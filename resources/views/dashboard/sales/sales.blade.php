@section('greeting')
    Goedemorgen, {{ auth()->user()->name }}!
@endsection

@extends('layouts.sales_dashboard_layout')

@section('content')
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800">Sales Dashboard</h1>

        <div class="mt-4">
            <h2 class="text-xl font-semibold text-gray-700">Welkom, [user]!</h2>
            <p class="text-gray-600 mt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <div class="bg-gray-200 p-4 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700">Stats or Info</h3>
                <p>Content or Graph</p>
            </div>
        </div>
    </div>
@endsection

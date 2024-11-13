@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Maintenance Tickets</h1>

        <div class="space-y-4">
            @foreach ($tickets as $ticket)
                <div class="bg-gray-200 p-4 rounded-lg

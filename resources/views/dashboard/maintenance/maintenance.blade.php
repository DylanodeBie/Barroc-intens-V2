@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="flex flex-grow">
        <nav class="bg-gray-800 text-white w-50 p-4">
            <ul class="space-y-4">
                <li class="p-2 rounded hover:bg-gray-700"><a href="#">Meldingen</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="#">Klanten</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="http://barroc-intens-v2.test/agenda">Agenda</a></li>
            </ul>
        </nav>
    </div>
</div>

@endsection

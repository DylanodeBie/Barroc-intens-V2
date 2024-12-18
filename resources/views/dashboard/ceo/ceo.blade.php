@extends('layouts.app')

@section('content')
    <div class="flex">
        <div class="flex flex-grow">
            <nav class="bg-gray-800 text-white w-50 p-4">
                <ul class="space-y-4">
                    <li class="p-2 rounded hover:bg-gray-700"><a href="http://barroc-intens-v2.test/customers">Klanten</a>
                    </li>
                    <li class="p-2 rounded hover:bg-gray-700"><a href="http://barroc-intens-v2.test/visits">Bezoeken</a></li>
                    <li class="p-2 rounded hover:bg-gray-700"><a href="http://barroc-intens-v2.test/products">Producten</a>
                    <li class="p-2 rounded hover:bg-gray-700"><a href="http://barroc-intens-v2.test/quotes">Offertes</a>
                    <li class="p-2 rounded hover:bg-gray-700"><a href="http://barroc-intens-v2.test/invoices">Facturen</a>
                    </li>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    </div>
@endsection

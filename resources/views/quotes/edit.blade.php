@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Quote</h1>
        <form action="{{ route('quotes.update', $quote->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" class="form-control">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $customer->id == $quote->customer_id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $quote->user_id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="machines">Machines</label>
                @foreach ($machines as $machine)
                    <div>
                        <input type="checkbox" name="machines[]" value="{{ $machine->id }}"
                            {{ $quote->machines->contains('id', $machine->id) ? 'checked' : '' }}>
                        {{ $machine->name }}
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label for="beans">Beans</label>
                <select name="beans[]" id="beans" class="form-control" multiple>
                    @foreach ($products as $bean)
                        <option value="{{ $bean->id }}"
                            {{ $quote->beans->contains('id', $bean->id) ? 'selected' : '' }}>
                            {{ $bean->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="agreement_length">Agreement Length</label>
                <input type="text" name="agreement_length" id="agreement_length" class="form-control"
                    value="{{ $quote->agreement_length }}">
            </div>

            <div class="form-group">
                <label for="maintenance_agreement">Maintenance Agreement</label>
                <select name="maintenance_agreement" id="maintenance_agreement" class="form-control">
                    <option value="basic" {{ $quote->maintenance_agreement == 'basic' ? 'selected' : '' }}>Basic</option>
                    <option value="premium" {{ $quote->maintenance_agreement == 'premium' ? 'selected' : '' }}>Premium
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Quote</button>
        </form>
    </div>
@endsection

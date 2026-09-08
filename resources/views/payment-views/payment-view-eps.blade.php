@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card text-center">
        <div class="card-body">
            <h3 class="mb-3">EPS Payment</h3>

            <p>Amount: <strong>{{ $data->amount }}</strong></p>

            <form method="POST" action="{{ route('eps.pay') }}">
                @csrf
                <input type="hidden" name="payment_id" value="{{ $data->id }}">
                <button type="submit" class="btn btn-success btn-lg">
                    Pay with EPS
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

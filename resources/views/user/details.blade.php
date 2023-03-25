@extends('user.layout.style')

@section('content')

<div class="row mt-5 d-flex justify-content-center">

    <div class="col-4 ">
        <img src="{{ asset('uploads/'.$pizza->image) }}" class="img-thumbnail" width="100%">            <br>
        <a href="{{ route('user#order') }}"><button class="btn btn-primary float-end mt-2 col-12"><i class="fas fa-shopping-cart"></i> Order</button>
        </a>
        <a href="{{ route('user#index') }}">
            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                <i class="fas fa-backspace"></i> Back
            </button>
        </a>
    </div>
    <div class="col-6">

        <h5>Name</h5>
        <small>{{ $pizza->pizza_name }}</small>
        <hr/>

        <h5>Price</h5>
        <small>{{ $pizza->price }} Kyats</small>
        <hr/>

        <h5>Discount Price</h5>
        <small>{{ $pizza->discount_price }} Kyats</small>
        <hr/>

        <h5>Buy One Get One</h5>
        <small>
            @if ($pizza->buy_one_get_one_status == 0)
                <b class="text-danger bold">NO</b>
                @else
                <b class="text-success bold">YES</b>
            @endif
        </small>
        <hr/>

        <h5>Waiting Time</h5>
        <small>{{ $pizza->waiting_time }} Minutes</small>
        <hr/>

        <h5>Description</h5>
        <small>{{ $pizza->description }}</small>
        <hr/>

        <h5>Total Price</h5>
        @if ($pizza->buy_one_get_one_status == 0)
        <h5 class="text-success">{{ $pizza->price - $pizza->discount_price }} Kyats</h5>
                @else
        <h5 class="text-success">{{ $pizza->price - $pizza->discount_price }} Kyats</h5>
        {{-- For <span class="text-danger">Two</span> Pizzas --}}
            @endif

        <hr/>
    </div>
</div>
@endsection

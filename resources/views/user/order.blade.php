@extends('user.layout.style')

@section('content')

<div class="row mt-5 d-flex justify-content-center">

    <div class="col-4 ">
        <img src="{{ asset('uploads/'.$pizza->image) }}" class="img-thumbnail" width="100%"> <br>
        <a href="{{ route('user#index') }}">
            <button class="btn btn-dark text-white mt-2">
             <i class="fas fa-backspace"></i> Back
            </button>
        </a>
    </div>
    <div class="col-6">
        @if (Session::has('totalTime'))
        <div class="alert alert-success alert-dismissible fade show mt-2 text-center" role="alert">
            Order Success! Please Wait {{ Session::get('totalTime') }}Minutes
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (Session::has('orderError'))
        <div class="alert alert-danger alert-dismissible fade show mt-2 text-center" role="alert">
           {{ Session::get('orderError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <h5>Name</h5>
        <small>{{ $pizza->pizza_name }}</small>
        <hr/>

        <h5>Price</h5>
        <small>{{ $pizza->price - $pizza->discount_price  }} Kyats</small>
        <hr/>

        <h5>Waiting Time</h5>
        <small>{{ $pizza->waiting_time }} Minutes</small>
        <hr/>

        <form action="" method="post">
            @csrf
            <h5>Pizza Count</h5>
        <input type="number" name="pizzaCount" id="" class="form-control" placeholder="Number of pizza">
            @if ($errors->has('pizzaCount'))
                <p class="text-danger">{{ $errors->first('pizzaCount') }}</p>
            @endif
        <hr/>

        <h5>Payment Type</h5>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="paymentType" id="inlineCheckbox1" value="1">
            <label class="form-check-label" for="inlineCheckbox1">Credit Card</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="paymentType" id="inlineCheckbox2" value="2">
            <label class="form-check-label" for="inlineCheckbox2">Cash</label>
          </div>
            @if ($errors->has('paymentType'))
                <p class="text-danger">{{ $errors->first('paymentType') }}</p>
            @endif
          <hr>
         <button class="btn btn-primary mt-3"><i class="fas fa-shopping-cart"></i> Place Order</button>

        </form>
    </div>
</div>
@endsection

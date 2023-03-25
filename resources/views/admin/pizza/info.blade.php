@extends('admin.layout.app')


@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-9 offset-2 mt-3">
            <div class="col-md-10">
                <a href="{{ route('admin#pizza') }}" class="text-decoration-none text-dark"><div class="mb-2"><i class="fas fa-arrow-left"></i> Back</div></a>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Pizza Info</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane d-flex justify-content-center" id="activity">
                        <div class="d-flex align-items-center mr-3">
                            <img src="{{ asset('uploads/'.$pizza->image) }}" class="img-thumbnail rounded mr-3" style="width:200px; height:150px">
                        </div>
                        <div>
                            <div class="mt-3">
                                <b>Name</b> : <span>{{ $pizza->pizza_name }}</span>
                            </div>
                            <div class="mt-3">
                                <b>Price</b> : <span>{{ $pizza->price }} Kyats</span>
                            </div>
                            <div class="mt-3">
                                <b>Publish Status</b> :
                                <span>
                                    @if ($pizza->publish_status == 1)
                                        YES
                                    @else
                                        NO
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3">
                                <b>Category</b> : <span>{{ $pizza->category_id }}</span>
                            </div>
                            <div class="mt-3">
                                <b>Discount Price</b> : <span>{{ $pizza->discount_price }} Kyats</span>
                            </div>
                            <div class="mt-3">
                                <b>Buy One Get One Status</b> :
                                <span>
                                    @if ($pizza->buy_one_get_one_status == 1)
                                        YES
                                    @else
                                        NO
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3">
                                <b>Waiting Time</b> : <span>{{ $pizza->waiting_time }} minutes</span>
                            </div>
                            <div class="mt-3">
                                <b>Description</b> : <span>{{ $pizza->description }}</span>
                            </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

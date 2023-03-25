@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">

        <div class="row mt-4">
          <div class="col-10 offset-1">
            <h3 class="my-3">{{ $pizza[0]->categoryName }}</h3>
            <div class="card">
              <div class="card-header">

                <span class="fs-5 ml-5">Total : {{ $pizza->total() }}</span>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-center">
                    <thead class="table-secondary">
                      <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Pizza Name</th>
                        <th>Price</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach ($pizza as $item)
                      <tr>
                          <td>{{ $item->pizza_id }}</td>
                          <td>
                             <img src="{{ asset('uploads/'.$item->image) }}" width="150px">
                          </td>
                          <td>{{ $item->pizza_name }}</td>
                          <td>{{ $item->price }}</td>
                      </tr>
                      @endforeach
                    </tbody>

                </table>

                <div class="mt-4 ms-3">{{ $pizza->links() }}</div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <a href="{{ route('admin#category') }}">
                    <button class="btn btn-dark text-white">Back</button>
                </a>
              </div>

            </div>
            <!-- /.card -->

          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

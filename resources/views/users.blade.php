@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Customers Table') }}</h1>

<div class="row justify-content-center">

    <div class="col-lg-8">



        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Mobile No.</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            @php($count=1)
                            @foreach ($customers as $customer)
                            <tr>
                                <td>
                                    <!-- {{ $customer->id }}<br> -->
                                    {{ $count }}
                                </td>
                                <td>
                                    {{ $customer->name }}
                                </td>
                                <td>
                                    {{ $customer->phone }}
                                </td>
                                <td>
                                    {{ $customer->email }}
                                </td>
                                <td>
                                    @if ($customer->status == 0)
                                    <button class="btn btn-danger customer-status-btn" data-id="{{ $customer->id }}" id="customer-status-btn"> Inactive </button>
                                    @else
                                    <button class="btn btn-success" data-id="{{ $customer->id }}" id="customer-status-btn"> Active </button>
                                    @endif

                                    @if ($customer)
                                    <button class="btn btn-danger customer-delete-btn" data-id="{{ $customer->id }}" id="customer-delete-btn"> Delete </button>
                                    @endif
                                </td>
                            </tr>
                            @php($count++)
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.customer-status-btn').click(function() {
            if ($(this).hasClass('btn-danger')) {
                $(this).removeClass('btn-danger');
                $(this).addClass('btn-success');
                $(this).text('Active')
            } else {
                $(this).removeClass('btn-success');
                $(this).addClass('btn-danger');
                $(this).text('Inactive');
            };


            let customerId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('status-change') }}",
                data: {
                    'id': customerId
                },
                success: function(data) {
                    console.log(data.message);
                }
            });

        });
        $('.customer-delete-btn').click(function() {

            let customerId = $(this).data('id');
            let el=this;
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('customer-delete') }}",
                data: {
                    'id': customerId
                },
                success: function(data) {
                    $(el).closest( "tr" ).remove();
                    console.log(data.message);
                }
            });

        });
    });
</script>
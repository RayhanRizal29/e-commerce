@extends('layouts.app')
@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <title>Document</title>
</head>
<body style="background-color: #eeeeee">
    <div class="card-body">
    <h3>Order List</h3>

        <table class="table table-hover" id="table-data">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>User Id</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                {{-- <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('orders.detail', $order->id) }}" class="btn btn-sm btn-dark mr-2"><i class="fa fa-eye"></i></a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody> --}}
            </thead>
            
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("orders.data") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user_id', name: 'user_id' },
                { data: 'total_price', name: 'total_price' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
</body>
</html>

@endsection
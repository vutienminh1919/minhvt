@extends('layouts.master') <!-- Kế thừa file master.blade.php -->
@section('title', 'Danh sách người dùng')
@section('content')

    <div class="row">
        <form action="{{route('users.index')}}" class="w-100 d-flex flex-wrap">
            <div class="col-sm-3">
                <input type="text" class="form-control" id="name_search" value="{{request('name')}}" name="name"
                       placeholder="Nhập tên">
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="email_search" value="{{request('email')}}" name="email"
                       placeholder="Nhập email">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lọc</button>
            <a type="button" href="{{route('users.index')}}" class="btn btn-default">Bỏ lọc</a>
        </form>
    </div>

    <a type="button" class="btn btn-primary float-right" data-action="create" data-toggle="modal"
       data-target="#createUser">
        <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
    </a>

    <table class="table pt-5 table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th>STT</th>
            <th>Name</th>
            <th>Email</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($data))
            @foreach($data as $value)
                <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                    <td>{{$value['name']}}</td>
                    <td>{{$value['email']}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Thao tác
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Chi tiết</a>
                                <a class="dropdown-item updateUser" href="#" data-toggle="modal"
                                   data-id="{{$value['id']}}" data-action="update"
                                   data-target="#createUser">Chỉnh sửa</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <div class="float-right">
        {{ $data->links() }}
    </div>
    @include('Store::user.modal.create')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {


            $('#submitCreateUser').on('click', function () {
                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();

                // Kiểm tra dữ liệu trước khi gửi
                if (!name || !email || !password) {
                    return alert('Vui lòng điền đầy đủ thông tin.');
                }
                $.ajax({
                    url: '{{route('users.create')}}', // URL định nghĩa trong route
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        _token: '{{ csrf_token() }}' // CSRF token để bảo mật
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            // Đóng modal
                            $('#createUser').modal('hide');
                            // Reset các trường trong modal
                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: true,
                                timer: 3000,
                                didClose: () => {
                                    // Khi SweetAlert tự động đóng sau 3 giây
                                    window.location.reload(); // Reload trang
                                }
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                showConfirmButton: true,
                            });
                        }

                    },
                    error: function (xhr) {

                    }
                });
            })

            $('#submitUpdateUser').on('click', function () {
                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let id = $('#user_id').val();

                // Kiểm tra dữ liệu trước khi gửi
                if (!name || !email) {
                    return alert('Vui lòng điền đầy đủ thông tin.');
                }
                $.ajax({
                    url: '{{route('users.update')}}', // URL định nghĩa trong route
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        name: name,
                        email: email,
                        password: password,
                        _token: '{{ csrf_token() }}' // CSRF token để bảo mật
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            // Đóng modal
                            $('#createUser').modal('hide');
                            // Reset các trường trong modal
                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                showConfirmButton: true,
                                timer: 3000,
                                didClose: () => {
                                    // Khi SweetAlert tự động đóng sau 3 giây
                                    window.location.reload(); // Reload trang
                                }
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                showConfirmButton: true,
                            });
                        }

                    },
                    error: function (xhr) {
                    }
                });
            })

        })
    </script>
@endpush

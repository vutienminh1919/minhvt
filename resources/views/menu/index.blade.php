@extends('layouts.master') <!-- Kế thừa file master.blade.php -->
@section('title', 'Danh sách menu')
@section('content')

    <div class="row">
        <form action="{{route('menus.index')}}" class="w-100 d-flex flex-wrap">
            <div class="col-sm-3">
                <input type="text" class="form-control" id="title_search" value="{{request('title')}}" name="title"
                       placeholder="Nhập tên">
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="url_search" value="{{request('url')}}" name="url"
                       placeholder="Nhập đường dẫn">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lọc</button>
            <a type="button" href="{{route('menus.index')}}" class="btn btn-default">Bỏ lọc</a>
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
            <th>Tên</th>
            <th>Đường dẫn</th>
            <th>Menu cha</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($data))
            @foreach($data as $value)
                <tr>
                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                    <td>{{$value['title']}}</td>
                    <td>{{$value['url']}}</td>
                    <td>{{@$value['parent_name']}}</td>
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

            $(document).on('click', '[data-target="#createUser"]', function () {
                const action = $(this).data('action'); // Lấy giá trị data-action
                const modal = $('#createUser'); // Lấy modal

                if (action === 'create') {
                    // Hành động thêm mới
                    $('#submitUpdateUser').hide();
                    $('#submitCreateUser').show();
                    modal.find('.modal-title').text('Thêm mới người dùng'); // Thay đổi tiêu đề
                    modal.find('input').val(''); // Xóa dữ liệu trong form
                } else if (action === 'update') {
                    // Hành động chỉnh sửa
                    $('#submitCreateUser').hide();
                    $('#submitUpdateUser').show();
                    const userId = $(this).data('id'); // Lấy ID người dùng
                    console.log(userId);
                    $('#user_id').val(userId)
                    modal.find('.modal-title').text('Chỉnh sửa người dùng'); // Thay đổi tiêu đề

                    // Gửi AJAX để lấy thông tin người dùng
                    $.ajax({
                        url: '{{ route('users.getUser', ['id' => ':id']) }}'.replace(':id', userId),
                        method: 'GET',
                        success: function (response) {
                            modal.find('#name').val(response.name);
                            modal.find('#email').val(response.email);
                            modal.find('#password').val("");
                        },
                        error: function () {
                            alert('Không thể tải thông tin người dùng.');
                        }
                    });
                }

                modal.modal('show'); // Hiển thị modal
            });


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
                        // Xử lý lỗi
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Có lỗi xảy ra:\n';
                        $.each(errors, function (key, value) {
                            errorMessage += value[0] + '\n';
                        });
                        alert(errorMessage);
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
                        // Xử lý lỗi
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Có lỗi xảy ra:\n';
                        $.each(errors, function (key, value) {
                            errorMessage += value[0] + '\n';
                        });
                        alert(errorMessage);
                    }
                });
            })

        })
    </script>
@endpush

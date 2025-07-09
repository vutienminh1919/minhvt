@extends('layouts.master') <!-- Kế thừa file master.blade.php -->
@section('title', 'Danh sách menu')
@section('content')
    @if (session('success'))
        <div id="success-message"
             style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
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

    <a type="button" href="{{route('menus.showFormCreate')}}" class="btn btn-primary float-right" data-action="create">
        <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
    </a>

    <table class="table pt-5 table-hover table-sm">
        <thead class="thead-light">
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Đường dẫn</th>
            <th>Menu cha</th>
            <th>Trạng thái</th>
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
                        <span
                            class="{{config('menu.status_color')[$value['status']]}}">{{config('menu.status')[$value['status']]}}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Thao tác
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item lock_menu" data-id="{{$value['id']}}"
                                   data-status="{{$value['status'] == config('menu.status_name')['ACTIVE'] ? '2': '1'}}"
                                   href="#">{{$value['status'] == config('menu.status_name')['ACTIVE'] ? 'Khoá': 'Mở'}}</a>
                                <a class="dropdown-item update_menu" href="#" data-toggle="modal"
                                   data-id="{{$value['id']}}"
                                   data-target="#updateMenu">Chỉnh sửa</a>
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
    @include('menu.modal.update')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            if ($('#success-message').length) {
                // Tự động ẩn thông báo sau 3 giây
                setTimeout(function () {
                    $('#success-message').fadeOut('slow'); // Hiệu ứng mờ dần
                }, 3000);
            }

            $('.lock_menu').on('click', function () {
                let id = $(this).data('id');
                let status = $(this).data('status');
                console.log(id);
                Swal.fire({
                    title: "Bạn có chắc chắn muốn thao tác hay không ?",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Huỷ",
                    icon: "question"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{route('menus.changeStatus')}}', // URL định nghĩa trong route
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id,
                                status: status,
                                _token: '{{ csrf_token() }}' // CSRF token để bảo mật
                            },
                            success: function (response) {
                                if (response.code == 200) {
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
                    }
                });
            })

            $('.update_menu').on('click', function () {
                let id = $(this).data('id');
                let detailUrl = "{{ route('menus.detail', ':id') }}".replace(':id', id); // Thay thế :id bằng giá trị thực tế
                $.ajax({
                    url: detailUrl, // URL định nghĩa trong route
                    type: 'GET',
                    success: function (response) {
                        if (response.code == 200) {
                            $('#parent_id').html(response.data.parent_menu)
                            $('#menu_id').val(id)
                            $('#title').val(response.data.detail.title)
                            $('#url').val(response.data.detail.url)
                            $('#icon').val(response.data.detail.icon)
                            $('#display_order').val(response.data.detail.display_order)
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
            $('#submitUpdateMenu').on('click', function () {
                let title = $('#title').val();
                let url = $('#url').val();
                let parent_id = $('#parent_id').val();
                let display_order = $('#display_order').val();
                let icon = $('#icon').val();
                let id = $('#menu_id').val();

                // Kiểm tra dữ liệu trước khi gửi

                $.ajax({
                    url: '{{route('menus.update')}}', // URL định nghĩa trong route
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        title: title,
                        url: url,
                        parent_id: parent_id,
                        display_order: display_order,
                        icon: icon,
                        _token: '{{ csrf_token() }}' // CSRF token để bảo mật
                    },
                    success: function (response) {
                        if (response.code == 200) {
                            // Đóng modal
                            $('#updateMenu').modal('hide');
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

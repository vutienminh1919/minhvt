@extends('layouts.master') <!-- Kế thừa file master.blade.php -->
@section('title', 'Thêm mới menu')
@section('content')
    <form action="{{route('menus.create')}}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Menu cha</label>
                <select class="form-control select2" style="width: 100%;" name="parent_id">
                    {!! $menu !!}
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tên</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="Nhập tên">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">URL</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="url" placeholder="Nhập URL">
            </div>
            <div class="form-group">
                <label for="">Icon</label>
                <input type="text" class="form-control" id="" name="icon" placeholder="Nhập icon">
            </div>
            <div class="form-group">
                <label for="">Thứ tự</label>
                <input type="text" class="form-control" id="" name="display_order" placeholder="Nhập thứ tự">
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a type="button" href="{{route('menus.index')}}" class="btn btn-default">Quay lại</a>
        </div>
    </form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
        })
    </script>
@endpush

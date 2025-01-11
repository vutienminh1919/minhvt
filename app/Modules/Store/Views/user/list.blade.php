@extends('layouts.master') <!-- Kế thừa file master.blade.php -->
@section('title', 'Danh sách người dùng')
@section('content')
   <table class="table">
       <thead>
       <tr>
           <th>STT</th>
           <th>Name</th>
           <th>Email</th>
       </tr>
       </thead>
       <tbody>
       @if(!empty($data))
           @foreach($data as $value)
                <tr>
                    <td>{{$value['id']}}</td>
                    <td>{{$value['name']}}</td>
                    <td>{{$value['email']}}</td>
                </tr>
           @endforeach
       @endif
       </tbody>
   </table>
@endsection

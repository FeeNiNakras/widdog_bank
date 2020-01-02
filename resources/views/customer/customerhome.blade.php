@extends('layouts.app')

@section('content')
<div class="container">
        
        <h1>ข้อมูลลูกค้า</h1>
        <br>
        <div align="right"><a href="{{route('customer.create')}}" class="btn btn-success">เพิ่มข้อมูล</a></div>
        <br>
        @if(\Session::has('success'))
            <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
            </div>
        @endif
         <table class="table table-bordered table-striped">
         <tr><th>ชื่อ</th>
         <th>นามสกุล</th>
         <th>เบอร์โทรศัพท์</th>
         <th>ที่อยู่</th>
         <th>E-mail</th>
         <th>รูป</th>
         <th>แก้ไข</th>
         <th>ลบ</th></tr>
         @foreach($customers as $row)
         <tr><td>{{$row['fname']}}</td>
         <td>{{$row['lname']}}</td>
         <td>{{$row['phone']}}</td>
         <td>{{$row['address']}}</td>
         <td>{{$row['email']}}</td>
         <td><a href="{{ asset('images/'.$row['image']) }}"><img src="{{ asset('images/resize/'.$row['image']) }}"></a></td>
         <!-- <td><a href="{{ asset('images/'.$row['image']) }}"><img src="{{ asset('images/resize/'.$row['image']) }}"></a></td> -->
         <!-- <td>{{$row['image']}}</td> -->
         <td><a href="{{ route('customer.edit', $row['id']) }}" class="btn btn-warning">แก้ไข</a></td>
         <td>
                <form action="{{ route('customer.destroy', $row['id']) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('คุณต้องการที่จะลบข้อมูลหรือไม่ ?')">ลบ</button>
                </form></td></tr>
         @endforeach
         </table>
</div>
@endsection
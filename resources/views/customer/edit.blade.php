@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h3>แก้ไขข้อมูลลูกค้า</h3>

        @if(count($errors)>0)
            <div class="alert alert-danger">
            <ul> @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
            </ul>
            </div>
        @endif
        @if(\Session::has('success'))
            <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
            </div>
        @endif

        <form method="post" action="{{route('customer.update', $id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <input type="text" name="fname" class="form-control" placeholder="ป้อนชื่อ" value="{{$customer->fname}}" />
        </div>
        <div class="form-group">
            <input type="text" name="lname" class="form-control" placeholder="ป้อนนามสกุล" value="{{$customer->lname}}" />
        </div>
        <div class="form-group">
            <input type="text" name="phone" class="form-control" placeholder="ป้อนเบอร์โทรศัพท์" value="{{$customer->phone}}" />
        </div>
        <div class="form-group">
            <input type="text" name="address" class="form-control" placeholder="ป้อนที่อยู่" value="{{$customer->address}}" />
        </div>
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="E-mail" value="{{$customer->email}}" />
        </div>
        <div class="form-group">
            <h5 class="card-title">รูปภาพ</h5>
            <a href="{{ asset('images/'.$customer->image) }}"><img src="{{asset('images/resize/'.$customer->image) }}" style="width:100px"></a>
                <label for="input-file-now">เลือกรูปภาพที่จะอัพโหลด —</label>
                <input type="file" id="input-file-now" name="image" class="dropify"  />
                <input type="hidden" name="image" class="form-control" placeholder="รูปภาพ" value="{{$customer->image}}" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="อัพเดท" />
        </div>
            <input type="hidden" name="_method" value="PATCH" />

        </form>
        </div>
    </div>
   
</div>
@endsection
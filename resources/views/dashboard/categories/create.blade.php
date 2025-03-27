@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@endsection

@section('title')
    category
@endsection
@section('content')
<form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    @if($errors->any())
        <div class="alert alert-danger">
            <h3>error occured!</h3>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>

                @endforeach
            </ul>

        </div>

    @endif

    <div class="form-group">
         <label for=""> category name</label>
         <input type="text" name="name" class="form-control" value="{{old('name')}}">
       {{-- <x-form.input name="name" type="text" value="{{$category->name}}" role="input" />--}}
     </div>

    <div class="form-group">
        <label for=""> category parent</label>
        <select name="parent_id" class="form-control form-select">
            <option value="">primary category</option>
            @foreach($parents as $parent)
                <option value="{{$parent->id}}">{{$parent->name}}</option>
            @endforeach

        </select>
    </div>

    <div class="form-group">
        <label for="">  description</label>
        <textarea  name="description" class="form-control"  value="{{old('description')}}"></textarea>

    </div>

    <div class="form-group">
        <label for=""> image</label>
        <input type="file" name="image" class="form-control" value="{{old('image')}}" >
    </div>

    <div class="form-group">
        <label for=""> status</label>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="{{old('description')}}" name="status" >
                <label class="form-check-label" >
                   active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="archived" name="status"  >
                <label class="form-check-label" >
                    archived

                </label>
            </div>
        </div>

    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">save</button>
    </div>









</form>
@endsection



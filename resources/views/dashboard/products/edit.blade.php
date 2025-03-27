@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item active">Starter Page</li>
@endsection

@section('title')
    Edit Category
@endsection
@section('content')
<form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
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
        <label for="">  name</label>
        <textarea  name="name" class="form-control">{{old('name',$product->name)}}</textarea>

    </div>

    {{-- <div class="form-group">
         <label for=""> category parent</label>
         <select name="parent_id" class="form-control form-select">
             <option value="">primary category</option>
             @foreach($parents as $parent)
                 <option value="{{$parent->id}}"@selected($category->parent_id==$parent->id)>{{$parent->name}}</option>
             @endforeach

         </select>
     </div>--}}

    <div class="form-group">
        <label for="">  description</label>
        <textarea  name="description" class="form-control">{{old('description',$product->description)}}</textarea>

    </div>
    <div class="form-group">
        <label for="">  price</label>
        <textarea  name="price" class="form-control">{{old('price',$product->price)}}</textarea>

    </div>
    <div class="form-group">
        <label for="">  compare_price</label>
        <textarea  name="compare_price" class="form-control">{{old('compare_price',$product->compare_price)}}</textarea>

    </div>
    {{--
    <div class="form-group">
        <label for="">  tag</label>
        <textarea  name="tag" class="form-control">{{old('tag',$product->tag)}}</textarea>

    </div>--}}

    <div class="form-group">
        <label for=""> image</label>
        <input type="file" name="image" class="form-control @error('name') is-invalid" @enderror >
        @if($product->image)
            <img src="{{asset('storage/'.$product->image)}}" alt="" height="50">
        @endif

    </div>

    <div class="form-group">
        <label for=""> status</label>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="active" name="status" @checked($product->status == 'active')>
                <label class="form-check-label" >
                   active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="archived" name="status" @checked($product->status == 'archived') >
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



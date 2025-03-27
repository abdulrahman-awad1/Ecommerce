@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item active"> products</li>
@endsection

@section('title')
    products
@endsection
@section('content')
    <div class="mb-">
        <a href="{{route('products.create')}}" class="btn btn-sm btn-outline-primary">create</a>
      {{--  <a href="{{route('products.trash')}}" class="btn btn-sm btn-outline-dark">trash</a>--}}
    </div>

    @if(session()->has('success')) // z  وانا عرضتها   session اتبعتت الي success رساله ال
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif

    <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
        <input type="text" name="name" placeholder="name" class="form-control mx-2" value="{{request('name')}}" >

        <select name="status"  class="form-control mx-2" >
            <option value=>all</option>
            <option value="active" @selected(request('status')=='active')>active</option>
            <option value="archived"  @selected(request('status')=='archived')>archived</option>
        </select>
        <button class="btn btn-dark mx-2">filter</button>

    </form>

<table class="table">
    <thead>
    <tr>
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>category</th>
        <th>store</th>
        <th>status</th>
        <th>Created At</th>
        <th colspan=2></th>
    </tr>
    </thead>
    <tbody>
    @if($products->count())
    @foreach($products as $product)
    <tr>

        <td><img src="{{asset('storage/'.$product->image)}}" alt="" height="50"></td>
        <td>{{$product->id}}</td>
        <td>{{$product->name}}</td>
        <td>{{$product->category->name}}</td>{{--لان ف ريلاشن بين جدول البرودكت والكاتيجوري , فأنا من خلال موديل البرودكت قدرت اوصل لموديل للكاتوجيري الخاص بيه واستدعي السم--}}
        <td>{{$product->store->name}}</td>{{--نفس السطر ال فوق--}}
        <td>{{$product->status}}</td>
        <td>{{$product->created_at}}</td>
        <td>
            <a href="{{route('products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">edit</a>
        </td>
        <td>
            <form action="{{route('products.destroy',$product->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
    @else
        <tr>
            <td colspan="9"> no products defined</td>
        </tr>
    @endif

    </tbody>
</table>
    {{$products->withQueryString()->links()}}
@endsection



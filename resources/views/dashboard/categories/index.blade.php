@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item active"> categories</li>
@endsection

@section('title')
    category
@endsection
@section('content')
    <div class="mb-">
        <a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">create</a>
        <a href="{{route('categories.trash')}}" class="btn btn-sm btn-outline-dark">trash</a>
    </div>

    @if(session()->has('success')) // z  وانا عرضتها   session اتبعتت الي success رساله ال
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif

    <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
        <input type="text" name="name" class="form-control mx-2" value="{{request('name')}}" >

        <select name="status" class="form-control mx-2" >
            <option value=""></option>
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
        <th>Parent</th>
        <th>product#</th>
        <th>status</th>
        <th>Created At</th>
        <th colspan=2></th>
    </tr>
    </thead>
    <tbody>
    @if($categories->count())
    @foreach($categories as $category)
    <tr>

        <td><img src="{{asset('storage/'.$category->image)}}" alt="" height="50"></td>
        <td>{{$category->id}}</td>
        <td><a href="{{route('categories.show' , $category->id)}}">{{$category->name}}</a></td>
        <td>{{$category->parent->name}}</td>
        <td>{{$category->product_number}}</td>
        <td>{{$category->status}}</td>
        <td>{{$category->created_at}}</td>
        <td>
            <a href="{{route('categories.edit',$category->id)}}" class="btn btn-sm btn-outline-success">edit</a>
        </td>
        <td>
            <form action="{{route('categories.destroy',$category->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
    @else
        <tr>
            <td colspan="7"> no categories defined</td>
        </tr>
    @endif

    </tbody>
</table>
    {{$categories->withQueryString()->links()}}
@endsection



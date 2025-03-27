@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item ">categories</li>
    <li class="breadcrumb-item active">trash</li>
@endsection

@section('title')
   trashed category
@endsection
@section('content')
    <div class="mb-">
        <a href="{{route('categories.index')}}" class="btn btn-sm btn-outline-primary">back</a>
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
        <th>status</th>
        <th>deleted At</th>
        <th colspan=2></th>
    </tr>
    </thead>
    <tbody>
    @if($categories->count())
    @foreach($categories as $category)
    <tr>

        <td><img src="{{asset('storage/'.$category->image)}}" alt="" height="50"></td>
        <td>{{$category->id}}</td>
        <td>{{$category->name}}</td>
        <td>{{$category->status}}</td>
        <td>{{$category->deleted_at}}</td>
        <td>
        </td>
        <form action="{{route('categories.restore',$category->id)}}" method="post">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-sm btn-outline-info">restore</button>
        </form>
        <td>
            <form action="{{route('categories.forceDelete',$category->id)}}" method="post">
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



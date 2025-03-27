@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item active"> show category</li>
@endsection

@section('title')
{{$category->name}}
@endsection
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>store</th>
            <th>status</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
      {{--  @if($products->count())--}}
            @foreach($category->products as $product)
                <tr>

                    <td><img src="{{asset('storage/'.$product->image)}}" alt="" height="50"></td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->store->name}}</td>{{--نفس السطر ال فوق--}}
                    <td>{{$product->status}}</td>
                    <td>{{$product->created_at}}</td>

                </tr>
            @endforeach
       {{-- @else--}}
          {{--  <tr>
                <td colspan="5"> no products defined</td>
            </tr>--}}
     {{--   @endif--}}

        </tbody>
    </table>
@endsection



@extends('layouts.dashboard')
@section('xx')
    @parent
    <li class="breadcrumb-item active">  Edit Profile</li>
@endsection

@section('title')
    Edit Profile
@endsection
@section('content')
    @if(session()->has('success')) // z  وانا عرضتها   session اتبعتت الي success رساله ال
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    <form action="{{route('profile.update',)}} "  method="post" enctype="multipart/form-data">
        @csrf
        @method('put')


        <div class="form-group">
            <label for=""> first name</label>
            <input type="text" name="first_name" class="form-control   value={{$user->profile->first_name}} >

        </div>
           <div class="form-group">
            <label for=""> last name</label>
            <input type="text" name="first_name" class="form-control   value={{$user->profile->last_name}} >

        </div>
           <div class="form-group">
            <label for=""> birthdate</label>
            <input type="date" name="birthdate" class="form-control   value={{$user->profile->birthdate}} >

        </div>
          <div class="form-group">
            <label for=""> gender</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="male" name="gender" @checked($user->profile->gender == 'male')>
                    <label class="form-check-label" >
                        male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="female" name="gender" @checked($user->profile->gender == 'female') >
                    <label class="form-check-label" >
                        female

                    </label>
                </div>
            </div>

        </div>
        <div class="form-group">
            <label for=""> street address</label>
            <input type="text" name="street_address" class="form-control   value={{$user->profile->street_address}} >

        </div>
         <div class="form-group">
            <label for=""> city</label>
            <input type="text" name="city" class="form-control   value={{$user->profile->city}} >

        </div>
         <div class="form-group">
            <label for=""> state</label>
            <input type="text" name="state" class="form-control   value={{$user->profile->state}} >

        </div>
        <div class="form-group">
            <label for=""> postal code</label>
            <input type="text" name="postal_code" class="form-control   value={{$user->profile->postal_code}} >

        </div>

          <div class="form-group">
            <label for=""> country</label>
            <select name="country" class="form-control form-select">
                <option value="">country</option>
                @foreach($countries as $country)
                    <option value="{{$country}}"@selected($user->profile->country)>{{$country}}</option>
                @endforeach

            </select>
        </div>
        <div class="form-group">
            <label for=""> language</label>
            <select name="country" class="form-control form-select">
                <option value="">language</option>
                @foreach($languages as $language)
                    <option value="{{$language}}"@selected($user->profile->language)>{{$language}}</option>
                @endforeach

            </select>
        </div>

         <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
        </div>






     {{--   <div class="form-group">
            <label for=""> category parent</label>
            <select name="parent_id" class="form-control form-select">
                <option value="">primary category</option>
                @foreach($parents as $parent)
                    <option value="{{$parent->id}}"@selected($category->parent_id==$parent->id)>{{$parent->name}}</option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="">  description</label>
            <textarea  name="description" class="form-control">{{old('description',$category->description)}}</textarea>

        </div>

        <div class="form-group">
            <label for=""> image</label>
            <input type="file" name="image" class="form-control @error('name') is-invalid" @enderror >
            @if($category->image)
                <img src="{{asset('storage/'.$category->image)}}" alt="" height="50">
            @endif

        </div>

        <div class="form-group">
            <label for=""> status</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="active" name="status" @checked($category->status == 'active')>
                    <label class="form-check-label" >
                        active
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="archived" name="status" @checked($category->status == 'archived') >
                    <label class="form-check-label" >
                        archived

                    </label>
                </div>
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">save</button>
        </div>



--}}





    </form>
@endsection



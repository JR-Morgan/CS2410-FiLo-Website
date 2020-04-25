@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Edit and update the vehicle</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br/>
                @endif
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
                <br/>
                @endif
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{action('ItemController@update', $item['id'])}}" enctype="multipart/form-data" >
                        @method('PATCH')
                        @csrf
                        <div class="row col-md-10">
                            <label class="col-md-5">Category</label>
                            <select class="col-md-7" name="category">
                            @foreach(config('enums.itemCategory') as $value)
                            <option value="{{$value}}">{{ucfirst($value)}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="row col-md-10">
                            <label class="col-md-5">Time Found</label>
                            <input class="col-md-7" type="date" name="found_time" />
                        </div>
                        <div class="row col-md-10">
                            <label class="col-md-5">Location found</label>
                            <input class="col-md-7" type="text" name="found_location"/>
                        </div>
                        <div class="row col-md-10">
                            <label class="col-md-5">Color</label>
                            <select class="col-md-7" name="color">
                            @foreach(config('enums.itemColor') as $value)
                            <option value="{{$value}}">{{ucfirst($value)}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="row col-md-10">
                            <label class="col-md-5">Description</label>
                            <textarea class="col-md-7" rows="4" cols="50" name="description"> </textarea>
                        </div>
                        <div class="row col-md-10">
                            <label class="col-md-5">Image</label>
                            <input class="col-md-7" type="file" name="image" placeholder="Image file" />
                        </div>
                        <div class="col-md-7 col-md-offset-4">
                            <input type="submit" class="btn btn-primary" />
                            <input type="reset" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

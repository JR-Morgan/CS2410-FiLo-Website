<!--inherite master template app.blade.php -->
@extends('layouts.app')

<!--define the content section -->
@section('content')

<!--image input script -->
<script>
var counter = -1;

document.body.onload = function() {
        addImageInput()
    };

function addImageInput()
{
    counter++
    var id = `image${counter.toString()}`

    var newInput = document.createElement("input");
    newInput.setAttribute("id", id);
    newInput.setAttribute("type", "file");
    newInput.setAttribute("name", id);
    newInput.setAttribute("placeholder", "Image file");
    newInput.setAttribute("onChange", "checkAddImageInputEnabled()");

    document.getElementById('image-upload').appendChild(newInput);

    checkAddImageInputEnabled();
}

function checkAddImageInputEnabled()
{
    document.getElementById('add-input-button').disabled = document.getElementById(`image${counter.toString()}`).files.length == 0;
}
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 ">
            <div class="card">
                <div class="card-header">Create an new Item</div>
                <!--display the errors -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{{ $error }}}</li>
                        @endforeach
                    </ul>
                </div>
                <br/>
                @endif
                <!--display the success status -->
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
                <br/>
                @endif
                <!--define the form -->
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{url('items')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="text-align:right;">
                            <div class="row col-md-10">
                                <label class="col-md-5">Title</label>
                                <input class="col-md-7" type="text" name="title" maxlength="64" required/>
                            </div>
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
                                <input class="col-md-7" type="date" name="found_time" required/>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Location found</label>
                                <input class="col-md-7" type="text" name="found_location" maxlength="128" required/>
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
                                <textarea class="col-md-7" rows="4" cols="50" name="description" maxlength="256"></textarea>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Image</label>
                                <div id="image-upload" class="col-md-7"></div>
                                <div class="col-md-12">
                                    <input id="add-input-button" style="height:2em;width:2em;" type="button" value="+" onclick="addImageInput()">
                                </div>
                            </div>
                            <div class="row col-md-12">

                            </div>
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

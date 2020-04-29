@extends('layouts.app')
@section('content')
<!--image input script -->
<script src="{{ asset('js/imageInputElementCreator.js') }}"></script>

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
                        <div class="row" style="text-align:right;">
                            <div class="row col-md-10">
                                <label class="col-md-5">Title</label>
                                <input class="col-md-7" type="text" name="title" maxlength="64" value="{{$item['title']}}" required/>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Category</label>
                                <select class="col-md-7" name="category">
                                @foreach(config('enums.itemCategory') as $value)
                                    @if($value == $item['category'])
                                        <option value="{{$value}}" selected>{{ucfirst($value)}}</option>
                                    @else
                                        <option value="{{$value}}">{{ucfirst($value)}}</option>
                                    @endif

                                @endforeach
                                </select>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Time Found</label>
                                <input class="col-md-7" type="date" name="found_time" value="{{$item['found_time']}}" />
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Location found</label>
                                <input class="col-md-7" type="text" name="found_location" maxlength="128" value="{{$item['found_location']}}"/>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Color</label>
                                <select class="col-md-7" name="color" value="{{$item['color']}}" required>
                                @foreach(config('enums.itemColor') as $value)
                                    @if($value == $item['color'])
                                        <option value="{{$value}}" selected>{{ucfirst($value)}}</option>
                                    @else
                                        <option value="{{$value}}">{{ucfirst($value)}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Description</label>
                                <textarea class="col-md-7" rows="4" cols="50" maxlength="512" name="description">{{$item->description}}</textarea>
                            </div>
                            <div class="row col-md-12">
                                <label class="col-md-4">Remove Existing Images</label>
                                <ul style="text-align:left;">

                                    @if($item['image'])
                                        <?php $counter = 0 ?>
                                        @foreach(explode('|', $item['image']) as $image)
                                        <li id="previousImage{{$counter}}">
                                            <input type="button" value="Remove" onclick="removeElementById('previousImage{{$counter}}')" style="height: 2em;" />
                                            <a href="{{asset('storage/images/'.$image)}}" target="_blank">{{{$image}}}</a>
                                            <input type="hidden" name="previousImage{{$counter}}" value={{$image}}>

                                        </li>
                                        <?php $counter++ ?>
                                        @endforeach
                                    @else
                                        <li><i style="color:#808080">Item had no images attatched</i></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="row col-md-10">
                                <label class="col-md-5">Add New Images</label>
                                <div id="image-upload" class="col-md-7"></div>
                                <div class="col-md-12">
                                    <input id="add-input-button" style="height:2em;width:2em;" type="button" value="+" onclick="addImageInput()">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-md-offset-4">
                            <a href="{{action('ItemController@show', $item['id'])}}" class="btn btn-secondary" role="button">Back to item</a>
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

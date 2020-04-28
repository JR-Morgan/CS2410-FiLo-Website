@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Edit and update the item request</div>
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
                    <form class="form-horizontal" method="POST" action="{{action('ItemRequestController@update', $itemRequest['id'])}}" enctype="multipart/form-data" >
                        @method('PATCH')
                        @csrf
                        <div class="row col-md-8">
                            <label class="col-md-6">Message</label>
                            <textarea rows="4" cols="50" name="message" maxlength="512" class="col-md-6"> </textarea>
                        </div>
                        <div class="col-md-12 col-md-offset-4">
                            <a href="{{action('ItemRequestController@show', $itemRequest['id'])}}" class="btn btn-secondary" role="button">Back to request</a>
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

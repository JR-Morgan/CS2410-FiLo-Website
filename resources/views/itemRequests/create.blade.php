<!--inherite master template app.blade.php -->
@extends('layouts.app')
<!--define the content section -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 ">
            <div class="card">
                <div class="card-header">Request an Item</div>
                <!--display the errors -->
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
                <!--display the success status -->
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
                <br/>
                @endif
                <!--define the form -->
                <div class="card-body">
                    <p>Please give a reason for your request and provide details about the item.</p>
                    <p>Do NOT enter any personal information (telephone, email, or address). You will be emailed when your request is reviewed.</p>
                    <form class="form-horizontal" method="POST" action="{{url('itemrequests')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="itemId" value="{{$item['id']}}" />
                        <div class="row" style="text-align:right;">
                            <div class="row col-md-10">
                                <label class="col-md-4">Message</label>
                                <textarea class="col-md-8" rows="4" cols="50" name="message"> </textarea>
                            </div>
                        </div>
                        <br/>
                        <div class="col-md-6 col-md-offset-4">
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

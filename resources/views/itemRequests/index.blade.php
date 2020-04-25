@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Display all item request</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>User</th>
                                <th>State</th>
                                <th colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itemRequests as $itemRequest)
                                <tr>
                                    <td><a href="{{action('ItemController@show', $itemRequest['item_id'])}}" class="btn">{{$itemRequest['item_id']}}</a></td>
                                    <td>{{$itemRequest['claim_userid']}}</td>
                                    <td>{{ucfirst($itemRequest['state'])}}</td>
                                    <td><a href="{{action('ItemRequestController@show', $itemRequest['id'])}}" class="btn btn-primary">Display</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

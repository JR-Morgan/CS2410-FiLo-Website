@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Item request {{$itemRequest->id}} details</div>
                <div class="card-body">
                    <table class="table table-striped" border="1" >
                        <tr>
                            <th>Item</th>
                            <td><a href="{{action('ItemController@show', $itemRequest['item_id'])}}">{{$itemRequest->item_id}}</a></td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>{{$itemRequest->claim_userid}}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ucfirst($itemRequest->state)}}</td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td style="max-width:150px;" >{{$itemRequest->message}}</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            @can('itemRequestJudge', App\ItemRequest::find($itemRequest['id']))
                                <td><a href="{{action('ItemRequestController@approve', $itemRequest['id'])}}" class="btn btn-success">Approve</a></td>
                                <td><a href="{{action('ItemRequestController@reject', $itemRequest['id'])}}" class="btn btn-danger">Reject</a></td>
                            @endcan
                        </tr>
                    </table>
                    <table>
                        <tr>
                            @can('itemRequestViewAll')
                                <td><a href="{{action('ItemRequestController@index', $itemRequest['id'])}}" class="btn btn-secondary" role="button">Back to the list</a></td>
                            @endcan
                            @can('itemRequestEdit', App\ItemRequest::find($itemRequest['id']))
                                <td><a href="{{action('ItemRequestController@edit', $itemRequest['id'])}}" class="btn btn-warning">Edit</a></td>
                            @endcan
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

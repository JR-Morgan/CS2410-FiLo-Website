@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Display all item requests</div>
                <div class="card-body">
                    <table class="table table-striped" border="1" >
                        <tr>
                            <th>Item</th>
                            <td>{{$itemRequest->item_id}}</td>
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
                            <td><a href="{{action('ItemRequestController@index', $itemRequest['id'])}}" class="btn btn-primary" role="button">Back to the list</a></td>
                            @can('itemRequestEdit', App\ItemRequest::find($itemRequest['id']))
                                <td><a href="{{action('ItemRequestController@edit', $itemRequest['id'])}}" class="btn btn-warning">Edit</a></td>
                            @endcan
                            <td>
                                @can('itemRequestDelete', App\ItemRequest::find($itemRequest['id']))
                                    <form action="{{action('ItemRequestController@destroy', $itemRequest['id'])}}" method="post">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

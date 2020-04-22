@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Display all items</div>
                <div class="card-body">
                    <table class="table table-striped" border="1" >
                        <tr>
                            <th>Item category</th>
                            <td>{{$item->category}}</td>
                        </tr>
                        <tr>
                            <th>Item colour</th>
                            <td>{{$item->color}}</td>
                        </tr>
                        <tr>
                            <th>Location found</th>
                            <td>{{$item->found_location}}</td>
                        </tr>
                        <tr>
                            <th>Time found</th>
                            <td>{{$item->found_time}}</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td style="max-width:150px;" >{{$item->description}}</td>
                        </tr>
                        <tr>
                            <td colspan='2' >
                                <img style="width:100%;height:100%" src="{{asset('storage/'.$item->image)}}">
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><a href="{{route('items.index')}}" class="btn btn-primary" role="button">Back to the list</a></td>
                            @can('itemEdit', App\Item::find($item['id']))
                                <td><a href="{{action('ItemController@edit', $item['id'])}}" class="btn btn-warning">Edit</a></td>
                            @endcan
                            <td>
                                @can('itemDelete', App\Item::find($item['id']))
                                    <form action="{{action('ItemController@destroy', $item['id'])}}" method="post">
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

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Item {{$item->id}} details</div>
                <div class="card-body">
                    <table class="table table-striped" border="1" >
                        <tr>
                            <th>Title</th>
                            <td>{{ucfirst($item->title)}}</td>
                        </tr>
                        <tr>
                            <th>Item category</th>
                            <td>{{ucfirst($item->category)}}</td>
                        </tr>
                        <tr>
                            <th>Item colour</th>
                            <td>{{ucfirst($item->color)}}</td>
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
                                @if($item['image'])
                                    @foreach(explode('|', $item['image']) as $image)
                                    <img style="width:100%;height:100%" src="{{asset('storage/images/'.$image)}}">
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><a href="{{route('items.index')}}" class="btn btn-secondary" role="button">Back to the list</a></td>

                            @can('itemRequestCreate', $item)
                                <td><a href="{{action('ItemRequestController@create', array('itemId' => $item['id']))}}" class="btn btn-success">Request</a></td>
                            @endcan

                            @can('itemEdit', $item)
                                <td><a href="{{action('ItemController@edit', $item['id'])}}" class="btn btn-warning">Edit</a></td>
                            @endcan

                            <td>
                                @can('itemDelete', $item)
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

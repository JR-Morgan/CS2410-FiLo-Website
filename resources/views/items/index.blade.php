@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Display all items</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Colour</th>
                                <th>Time Found</th>
                                @auth
                                    <th colspan="3">Action</th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item['category']}}</td>
                                    <td>{{$item['color']}}</td>
                                    <td>{{$item['found_time']}}</td>

                                    @auth
                                        <td><a href="{{action('ItemController@show', $item['id'])}}" class="btn btn-primary">Details</a></td>
                                    @endauth
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

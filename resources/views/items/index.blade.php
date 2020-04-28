@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{action('ItemController@index')}}">
        <input type="hidden" name="filter" value="true" checked/>
        <div class="card">
            <div class="card-header">Search</div>
            <div class="card-body">
                <input style="width:85.5%" type="text" name="searchString" value="{{$searchString}}"/>
                <input style="width:14%" type="submit" value="Search">
            </div>
        </div>
        <br/>
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Filter options</div>
                <div class="card-body">
                    @foreach($activeFilters as $column => $filters)
                    <table class="table table-bordered">
                        <thead>
                            <th>{{$ucfsuffix = ucfirst($column)}}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:right;">
                                @foreach(config("enums.item{$ucfsuffix}") as $option)
                                    <label >{{ucfirst($option)}}</label>
                                    @if(in_array("{$option}", $activeFilters[$column]))
                                    <input type="checkbox" name="{{$column}}_{{$option}}" value="true" checked/>
                                    @else
                                    <input type="checkbox" name="{{$column}}_{{$option}}" value="true"/>
                                    @endif
                                    <br />
                                @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                    <input type="submit" value="Filter">
                </div>
            </div>
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header">Display all items</div>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
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
                                        <td>{{$item['title']}}</td>
                                        <td>{{ucfirst($item['category'])}}</td>
                                        <td>{{ucfirst($item['color'])}}</td>
                                        <td>{{$item['found_time']}}</td>

                                        @auth
                                            <td><a href="{{action('ItemController@show', $item['id'])}}" class="btn btn-primary">Details</a></td>
                                        @endauth
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if(count($items) == 0)
                            <p style="text-align:center">No Items to show</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

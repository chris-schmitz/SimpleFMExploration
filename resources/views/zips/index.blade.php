@extends('layout.default')

@section('title')
Zipcode Index
@stop

@section('content')

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3>All Zipcodes</h3>
    </div> 
    <div class="panel-body">
    Below is a list of all zipcodes within the US.
    <a class="btn btn-success pull-right" href="{{ route('api.zip.create') }}">New</a>
    </div> 
    <table class="table table-striped">
        <tr>
            <th>{{-- blank title for edit button --}}</th>
            @foreach($fields as $field)
                <th>{{$field}}</th>
            @endforeach
        </tr>
        @foreach($rows as $row)
            <tr>
                <td>
                    <a class="btn btn-success" href="{{ route('api.zip.edit', [ 'zip' => $row['zip'] ]) }}">Edit</a>
                </td>
                @foreach($fields as $field)
                    <td>{{$row[$field]}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div> 
@stop
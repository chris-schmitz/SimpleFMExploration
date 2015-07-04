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
                    <a class="btn btn-success" href="/api/zips/{{$row['zip']}}">Edit</a>
                </td>
                @foreach($fields as $field)
                    <td>{{$row[$field]}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div> 

<div class="well">
    {{var_dump($rows)}}
</div> 

@stop
@extends('layout.default')

@section('title')
Edit Zip {{ $zipRecord['zip'] }}
@stop

@section('content')

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3>Edit Zipcode {{ $zipRecord['zip'] }}</h3>
    </div> 
    <div class="panel-body">
        {{-- 
        Note, since we're not using the laravel form builder, we need
        to do our own method spoofing. The important parts are:
        - Use a post method in the form itself
        - Use a hidden input to note the PUT/PATCH/DELETE methods
        - Use a hidden input to add the csrf token
        --}}
        <form action="{{ route('api.zip.update', ['zip' => $zipRecord['zip'] ]) }}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="recid" value="{{ $zipRecord['recid'] }}">

            @include('zips._partials.zipform')
            
        </form>
        <form action="{{ route('api.zip.delete', ['zip' => $zipRecord['zip'] ]) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="recid" value="{{ $zipRecord['recid'] }}">

            <button type="submit" class="btn btn-danger">Delete</button>
        </form>

    </div> 

    <div class="panel-footer">
    </div>
</div> 

@stop
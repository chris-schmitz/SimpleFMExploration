@extends('layout.default')

@section('title')
Create Zipcode Record
@stop

@section('content')

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3>Create Zipcode</h3>
    </div> 
    <div class="panel-body">
        {{-- 
        Note, since we're not using the laravel form builder, we need
        to do our own method spoofing. The important parts are:
        - Use a post method in the form itself
        - Use a hidden input to note the PUT/PATCH/DELETE methods
        - Use a hidden input to add the csrf token
        --}}
        <form action="{{ route('api.zip.store') }}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('zips._partials.zipform')
            
        </form>
    </div> 

    <div class="panel-footer">
    </div>
</div> 

@stop
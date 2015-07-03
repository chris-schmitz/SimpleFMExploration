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
        <form action="{{ route('api.zip.update', ['zip' => $zipRecord['recid'] ]) }}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="zip">Zipcode</label>
                <input type="text" class="form-control" name="zip" value="{{ $zipRecord['zip'] }}">
            </div> 
            <div class="form-group">
                <label for="primary_city">Primary City</label>
                <input type="text" class="form-control" name="primary_city" value="{{ $zipRecord['primary_city'] }}">
            </div> 
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="form-control" name="state" value="{{ $zipRecord['state'] }}">
            </div> 
            <div class="form-group">
                <label for="county">County</label>
                <input type="text" class="form-control" name="county" value="{{ $zipRecord['county'] }}">
            </div> 
            <div class="form-group">
                <label for="timezone">Timezone</label>
                <input type="text" class="form-control" name="timezone" value="{{ $zipRecord['timezone'] }}">
            </div> 
            <div class="form-group">
                <label for="area_codes">Area Codes</label>
                <input type="text" class="form-control" name="area_codes" value="{{ $zipRecord['area_codes'] }}">
            </div> 
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control" name="country" value="{{ $zipRecord['country'] }}">
            </div> 
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" name="latitude" value="{{ $zipRecord['latitude'] }}">
            </div> 
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" name="longitude" value="{{ $zipRecord['longitude'] }}">
            </div> 

            <div class="form-group">
                <button type="submit" class="btn btn-success">Save</button>
                <a class="btn btn-danger" href="{{ route('api.zip.index', ['returnRowCount' => 50] ) }}">Cancel</a>
            </div> 
        </form>
    </div> 

    <div class="panel-footer">
    </div>
</div> 

@stop
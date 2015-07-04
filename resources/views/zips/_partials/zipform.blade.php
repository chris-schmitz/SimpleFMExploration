{{-- 
Note: FileMaker doesn't return nulls for empty fields, it returns an empty string. Because of this, we can't do the normal
laravel inspection of `{{ isset($myvar) ? $myvar : 'default value' }}` for the values.
--}}

<div class="form-group">
    <label for="zip">Zipcode</label>
    <input type="text" class="form-control" name="zip" value="{{ isset($zipRecord) ? $zipRecord['zip'] : null }}">
</div> 
<div class="form-group">
    <label for="primary_city">Primary City</label>
    <input type="text" class="form-control" name="primary_city" value="{{ isset($zipRecord) ? $zipRecord['primary_city'] : null }}">
</div> 
<div class="form-group">
    <label for="state">State</label>
    <input type="text" class="form-control" name="state" value="{{ isset($zipRecord) ? $zipRecord['state'] : null }}">
</div> 
<div class="form-group">
    <label for="county">County</label>
    <input type="text" class="form-control" name="county" value="{{ isset($zipRecord) ? $zipRecord['county'] : null }}">
</div> 
<div class="form-group">
    <label for="timezone">Timezone</label>
    <input type="text" class="form-control" name="timezone" value="{{ isset($zipRecord) ? $zipRecord['timezone'] : null }}">
</div> 
<div class="form-group">
    <label for="area_codes">Area Codes</label>
    <input type="text" class="form-control" name="area_codes" value="{{ isset($zipRecord) ? $zipRecord['area_codes'] : null }}">
</div> 
<div class="form-group">
    <label for="acceptable_cities">Acceptable Cities</label>
    <input type="text" class="form-control" name="acceptable_cities" value="{{  isset($zipRecord) ? $zipRecord['acceptable_cities'] : null }}">
</div> 
<div class="form-group">
    <label for="latitude">Latitude</label>
    <input type="text" class="form-control" name="latitude" value="{{ isset($zipRecord) ? $zipRecord['latitude'] : null }}">
</div> 
<div class="form-group">
    <label for="longitude">Longitude</label>
    <input type="text" class="form-control" name="longitude" value="{{ isset($zipRecord) ? $zipRecord['longitude'] : null }}">
</div> 

<div class="form-group">
    <button type="submit" class="btn btn-success">Save</button>

    <a class="btn btn-primary pull-right" href="{{ route('api.zip.index', ['returnRowCount' => 50] )}}">Back to list</a>
</div>

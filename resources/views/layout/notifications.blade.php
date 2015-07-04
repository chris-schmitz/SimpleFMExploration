@if(\Session::has('message'))

    @if(\Session::get('message')['style'] == 'success')
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success!</strong> {{\Session::get('message')['text']}}
        </div>
    @endif

    @if(\Session::get('message')['style'] == 'danger')
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> {{\Session::get('message')['text']}}
        </div>
    @endif

@endif

@if(count($errors) > 0)
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong>
      <ul>
        @foreach($errors->all() as $error) 
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif
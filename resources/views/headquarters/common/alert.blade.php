@if(session('success'))
  <div class="alert alert-success font-weight-bold mt-1">
    {{session('success')}}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger text-center">
    {{session('error')}}  
  </div>
@endif


@if(count($errors) > 0)
<div class="alert alert-danger font-weight-bold text-start mt-1">
  @foreach($errors->all() as $error)
  <li class="text-start">{{$error}}</li>
  @endforeach
</div>
@endif
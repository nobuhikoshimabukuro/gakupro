@if(session('success'))
  <div class="alert alert-success font-weight-bold mt-1">
    {{session('success')}}
  </div>
@endif

@if(session('job_information_ledger_error'))
  <div class="alert alert-danger font-weight-bold mt-1">
    求人情報出力時にエラーが発生しました。    
  </div>
@endif


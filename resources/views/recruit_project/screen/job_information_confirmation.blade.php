@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人情報管理画面')  
@endsection
@section('content')

<style>

table{
  width: 100%;
  border-collapse:separate;
  border-spacing: 0;
}

table th:first-child{
  border-radius: 5px 0 0 0;
}

table th:last-child{
  border-radius: 0 5px 0 0;
  border-right: 1px solid #3c6690;
}

table th{
  text-align: center;
  color:white;
  background: linear-gradient(#829ebc,#225588);
  border-left: 1px solid #3c6690;
  border-top: 1px solid #3c6690;
  border-bottom: 1px solid #3c6690;
  box-shadow: 0px 1px 1px rgba(255,255,255,0.3) inset;  
  padding: 10px 0;
}

table td{
  text-align: center;
  border-left: 1px solid #a8b7c5;
  border-bottom: 1px solid #a8b7c5;
  border-top:none;
  box-shadow: 0px -3px 5px 1px #eee inset;  
  padding: 10px 0;
}

table td:last-child{
  border-right: 1px solid #a8b7c5;
}

table tr:last-child td:first-child {
  border-radius: 0 0 0 5px;
}

table tr:last-child td:last-child {
  border-radius: 0 0 5px 0;
}

</style>

<div id="main" class="mt-3 text-center container">
    
    @include('recruit_project.common.alert')

    <div id="" class="row m-0 p-0">

      <div id="button-area" class="row mb-2 p-0">        
        <div class="col-12 m-0 p-0" align="right">              
          <button type="button" id="" class="btn btn-primary" onclick="location.href='{{ route('recruit_project.job_information_register') }}'">求人情報新規作成　<i class="fas fa-user-edit"></i></button>
        </div>        
      </div>   
      
      <div id="" class="row m-0 p-0 scroll-wrap-x">

        <table id='' class='data-info-table m-0 p-0'>            
            <tr>
                <th>求人ID</th>
                <th>タイトル</th>
                <th></th>
                <th></th>
                
            </tr>
            @foreach ($job_information_list as $Index =>  $info)
                <tr>
                    <td>{{$info->job_id}}</td>
                    <td>{{$info->title}}</td>
                    
                    <td>                      
                      <button type="button" id="" class="btn btn-primary" onclick="location.href='{{ route('recruit_project.job_publish_info',['job_id' => $info->job_id]) }}'">掲載期間確認　<i class="fas fa-user-edit"></i></button>
                    </td>
                    
                    <td>                      
                      <button type="button" id="" class="btn btn-primary" onclick="location.href='{{ route('recruit_project.job_information_register',['job_id' => $info->job_id]) }}'">求人内容編集　<i class="fas fa-user-edit"></i></button>
                    </td>
                 
                </tr>    
            @endforeach

        </table>

      </div>   

    </div>   

      
    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    $(window).on('load', function() { 

        LoaderEnd();

    });

});

</script>
@endsection


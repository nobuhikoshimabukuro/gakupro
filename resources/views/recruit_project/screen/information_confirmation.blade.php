@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '雇用者情報管理画面')  
@endsection
@section('content')

<style>
table{
  width: 100%;
  border-collapse: collapse;
}

table tr{
  border-bottom: solid 2px white;
}

table tr:last-child{
  border-bottom: none;
}

table th{
  position: relative;
  text-align: left;
  width: 30%;
  background-color: #52c2d0;
  color: white;
  text-align: center;
  padding: 10px 0;
}

table th:after{
  display: block;
  content: "";
  width: 0px;
  height: 0px;
  position: absolute;
  top:calc(50% - 10px);
  right:-10px;
  border-left: 10px solid #52c2d0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
}

table td{
  text-align: left;
  width: 70%;
  text-align: center;
  background-color: #eee;
  padding: 10px 0;
}

</style>

<div id="main" class="mt-3 text-center container">
    
 
  <div class="row p-0 d-flex justify-content-center">

    <div class="col-11 col-md-9 mt-3">    

      @include('recruit_project.common.alert')

      <table class="">
        
        <tr>
          <th>雇用者名</th>
          <td>
            
            <ruby>
              <rb>{{$employer_info->employer_name}}</rb>
              <rp>
                （</rp><rt>{{$employer_info->employer_name_kana}}</rt><rp>）
              </rp>
            </ruby>
          </td>
        </tr>

        <tr>
          <th>郵便番号</th>
          <td>
            {{$employer_info->post_code}}
          </td>
        </tr>

        <tr>
          <th>住所</th>
          <td>
            {{$employer_info->address1}}　{{$employer_info->address2}}
          </td>
        </tr>

        <tr>
          <th>TEL</th>
          <td>
            {{$employer_info->tel}}
          </td>
        </tr>

        <tr>
          <th>FAX</th>
          <td>
            {{$employer_info->fax}}
          </td>
        </tr>

        <tr>
          <th>MailAddress</th>
          <td>
            {{$employer_info->mailaddress}}
          </td>
        </tr>

        <tr>
          <th>HP_Url</th>
          <td>
            <a href="{{$employer_info->hp_url}}" target="_blank" rel="noopener noreferrer">{{$employer_info->hp_url}}</a>            
          </td>
        </tr>

        
        <tr>
          <th>最終更新日時</th>
          <td>
            {{$employer_info->updated_at}}           
          </td>
        </tr>
        
      </table>

      <div id="button_area" class="row m-0 p-0">        
        <div class="col-12 p-0 mt-1" align="right">              
          <button type="button" id="" class="btn btn-primary" onclick="location.href='{{ route('recruit_project.information_register') }}'">編集　<i class="fas fa-user-edit"></i></button>
        </div>        
      </div>   
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


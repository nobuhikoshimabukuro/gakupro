@extends('recruit_project.common.layouts_afterlogin')

@section('pagehead')
@section('title', '求人情報管理画面')  
@endsection
@section('content')

<style>

.flash-area{
  display: inline-block;
  width: 20px;
}

.highlight-row{
  background-color: rgb(247, 248, 233);
}
.item-flash{
	animation: flash 2s linear infinite;
}

@keyframes flash {
	0% {
		opacity: 1;
	}
	50% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
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
                <th>掲載期間</th>
                <th>掲載状況</th>
                <th></th>
                <th></th>
                
            </tr>

            <form id="publish-flg-change-form" method="post" action="{{ route('recruit_project.job_information_publish_flg_change') }}">                    
              @csrf
              <input type="hidden" id="job_id" name="job_id" value="">
              <input type="hidden" id="publish_flg" name="publish_flg" value="">

                @foreach ($job_information_list as $job_information_index =>  $info)

                  @php
                    $job_id = $info->job_id;
                    $title = $info->title;
                    $publish_flg = $info->publish_flg;
                    $publish_data_flg = $info->publish_data_flg;                    

                    $job_password_connection_t = $info->job_password_connection_t;    
                  @endphp

                  @if($publish_data_flg == 1)
                    <tr class="highlight-row">
                  @else
                    <tr class="">
                  @endif
                  

                      <td>
                        {{$job_id}}
                      </td>

                      <td>
                        {{$title}}
                      </td>
                      
                      <td>
                          @foreach ($job_password_connection_t as $job_password_connection_index =>  $job_password_connection_info)

                            @if($job_password_connection_info->today_publish_flg == 1)
                              <div class="flash-area"><span class="item-flash">★</span></div>{{$job_password_connection_info->publish_start_date}}～{{$job_password_connection_info->publish_end_date}}
                            @else
                              <div class="flash-area"></div>{{$job_password_connection_info->publish_start_date}}～{{$job_password_connection_info->publish_end_date}}
                            @endif
                            
                            @if(count($job_password_connection_t) != $job_password_connection_index + 1)
                              <br>
                            @endif

                          @endforeach
                      </td>
                      

                      <td class="text-start">                      

                        @if($publish_data_flg == 1)

                          @if($publish_flg == 1)
                            掲載中
                            <button type="button" id='' class="btn btn-primary publish-flg-change-button btn-sm" 
                            data-jobid="{{$job_id}}" 
                            data-publishflg="{{$publish_flg}}" 
                            >掲載中断</button>                      
                          @else
                            掲載可能
                            <button type="button" id='' class="btn btn-primary publish-flg-change-button btn-sm" 
                            data-jobid="{{$job_id}}" 
                            data-publishflg="{{$publish_flg}}" 
                            >掲載開始</button>                      
                          @endif
                          
                          
                        @elseif($publish_data_flg == 0)
                          掲載期間外
                        @endif

                        
                      </td>

                      <td>
                        <button type="button" id="" class="btn btn-primary btn-sm" onclick="location.href='{{ route('recruit_project.job_publish_info',['job_id' => $job_id]) }}'">
                          掲載期間確認　<i class="far fa-calendar-alt"></i>
                        </button>
                      </td>
                      
                      <td>                      
                        <button type="button" id="" class="btn btn-primary btn-sm" onclick="location.href='{{ route('recruit_project.job_information_register',['job_id' => $job_id]) }}'">
                          求人内容編集　<i class="fas fa-user-edit"></i>
                        </button>
                      </td>
                    
                  </tr>    

                @endforeach
            </form>

        </table>

      </div>   

    </div>   

      
    
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

  $(window).on('load', function() { 

    

  });

  // 「保存」ボタンがクリックされたら
  $('.publish-flg-change-button').click(function () {
    
    var job_id = $(this).data("jobid");
    var publish_flg = $(this).data("publishflg");

    
    $("#job_id").val(job_id);
    $("#publish_flg").val(publish_flg);

    // ２重送信防止
    // 保存tを押したらdisabled, 10秒後にenable
    $(".publish-flg-change-button").prop("disabled", true);

    setTimeout(function () {
        $('.publish-flg-change-button').prop("disabled", false);
    }, 3000);

    //{{-- メッセージクリア --}}
    $('.ajax-msg').html('');
    $('.invalid-feedback').html('');
    $('.is-invalid').removeClass('is-invalid');

    let f = $('#publish-flg-change-form');

    //マウスカーソルを砂時計に
    document.body.style.cursor = 'wait';

    $.ajax({
        url: f.prop('action'), // 送信先
        type: f.prop('method'),
        dataType: 'json',
        data: f.serialize(),
    })
        // 送信成功
        .done(function (data, textStatus, jqXHR) {
            
            var result_array = data.result_array;

            var Result = result_array["Result"];

            
              //{{-- ボタン有効 --}}
              $('.publish-flg-change-button').prop("disabled", false);
              //{{-- マウスカーソルを通常に --}}                    
              document.body.style.cursor = 'auto';

            if(Result =='success'){

                location.reload();

            }else if(Result =='non_session'){

              // 店舗ログイン画面へ
              window.location.href = "{{ route('recruit_project.login') }}";

            }else{

                var ErrorMessage = result_array["Message"];

                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                errorsHtml = '<div class="alert alert-danger text-start">';
                errorsHtml += '<li class="text-start">' + ErrorMessage + '</li>';
                errorsHtml += '</div>';

                    //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
               

            }

        
        })

        // 送信失敗
        .fail(function (data, textStatus, errorThrown) {
            
            //{{-- ボタン有効 --}}
            $('.publish-flg-change-button').prop("disabled", false);
            //{{-- マウスカーソルを通常に --}}                    
            document.body.style.cursor = 'auto';

            //{{-- アラートメッセージ表示 --}}
            let errorsHtml = '<div class="alert alert-danger text-start">';

            if (data.status == '422') {
                //{{-- vlidationエラー --}}
                $.each(data.responseJSON.errors, function (key, value) {
                    //{{-- responsからerrorsを取得しメッセージと赤枠を設定 --}}
                    errorsHtml += '<li  class="text-start">' + value[0] + '</li>';
                
                    $("[name='" + key + "']").addClass('is-invalid');
                    
                    $("[name='" + key + "']").next('.invalid-feedback').text(value);
                });

            } else {

                //{{-- その他のエラー --}}
                errorsHtml += '<li class="text-start">更新処理エラー</li>';

            }

            errorsHtml += '</div>';
            
            //{{-- アラート --}}
            $('.ajax-msg').html(errorsHtml);
            //{{-- 画面上部へ --}}
            $("html,body").animate({
                scrollTop: 0
            }, "300");
           


        });

  });

});

</script>
@endsection


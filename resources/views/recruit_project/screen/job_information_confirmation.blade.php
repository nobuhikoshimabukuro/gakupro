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


/* 操作不可能 */
.impossible {
	pointer-events: none;
	opacity: 0.9;
}





 /* === ボタンを表示するエリア ============================== */
 .switch_area {
  line-height    : 30px;                /* 1行の高さ          */
  letter-spacing : 0;                   /* 文字間             */
  text-align     : center;              /* 文字位置は中央     */
  font-size      : 13px;                /* 文字サイズ         */
  position       : relative;            /* 親要素が基点       */
  margin         : auto;                /* 中央寄せ           */
  width          : 75px;               /* ボタンの横幅       */
  background     : transparent;                /* デフォルト背景色   */
}

 /* === チェックボックス ==================================== */
.switch_area input[type="checkbox"] {
  display        : none;            /* チェックボックス非表示 */
}




/* off時  start */

/* === チェックボックスのラベル ==================== */
.switch_area label {
  display        : block;               /* ボックス要素に変更 */
  box-sizing     : border-box;          /* 枠線を含んだサイズ */
  height         : 30px;                /* ボタンの高さ       */
  border         : 1px solid red;   /* 未選択タブのの枠線 */
  border-radius  : 15px;                /* 角丸               */
  background-color: white;
}

/* === 表示する文字 ================================ */
.switch_area label span:after{
  content        : "非公開";               /* 表示する文字       */
  padding        : 0 0 0 18px;          /* 表示する位置       */
  color          : red;             /* 文字色             */
}

/* === 丸部分のSTYLE =============================== */
.switch_area .switch_image {
  position       : absolute;            /* 親要素からの相対位置*/
  width          : 24px;                /* 丸の横幅           */
  height         : 24px;                /* 丸の高さ           */
  background     : red;             /* カーソルタブの背景 */
  top            : 3px;                 /* 親要素からの位置   */
  left           : 3px;                 /* 親要素からの位置   */
  border-radius  : 12px;                /* 角丸               */
  transition     : .1s;                 /* 滑らか変化         */  
}

/* off時  end */

/* on時  start */

  /* === チェックボックスのラベル（ONのとき） ================ */
  .on-class label {
    border-color   : #0d6efd;             /* 選択タブの枠線     */
  }

  /* === 表示する文字（ONのとき） ============================ */
  .on-class label span:after{
    content        : "公開中";                /* 表示する文字       */
    padding        : 0 20px 0 0px;          /* 表示する位置       */
    color          : #0d6efd;             /* 文字色             */
  }

  /* === 丸部分のSTYLE（ONのとき） =========================== */
  .on-class .switch_image {
    transform      : translateX(45px);    /* 丸も右へ移動       */
    background     : #0d6efd;             /* カーソルタブの背景 */    
  }
/* on時  end */

 

 



</style>


@if(session('job_information_ledger_error') == 1)
    <input type="hidden" id="job_information_ledger_error" value="1">
@else
    <input type="hidden" id="job_information_ledger_error" value="0">
@endif


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
                <th>公開期間</th>
                <th>公開状況</th>
                <th></th>
                <th></th>
                
            </tr>

            
            
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

                  <tr
                    @if($publish_data_flg == 1)
                      class="highlight-row"
                    @else
                      class=""
                    @endif                  
                  >

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
                      

                      <td class="text-center">

                        @if($publish_data_flg == 1) 

                          <div id="switch{{$job_id}}" 
                          @if($publish_flg == 1) 
                            class="switch_area on-class" 
                          @else
                            class="switch_area" 
                          @endif                                                      
                          data-jobid="{{$job_id}}" 
                          data-publishflg="{{$publish_flg}}"
                          
                          >                            
                            <label><span></span></label>
                            <div class="switch_image"></div>
                          </div>

                        @else

                          <div class="ng">
                            変更不可
                          </div>
                            
                        @endif
                        

                      
                      </td>

                      <td>
                        <button type="button" id="" class="btn btn-primary btn-sm" onclick="location.href='{{ route('recruit_project.job_publish_info',['job_id' => $job_id]) }}'">
                          公開期間設定　<i class="far fa-calendar-alt"></i>
                        </button>
                      </td>
                      
                      <td>                      
                        <button type="button" id="" class="btn btn-primary btn-sm" onclick="location.href='{{ route('recruit_project.job_information_register',['job_id' => $job_id]) }}'">
                          求人内容編集　<i class="fas fa-user-edit"></i>
                        </button>
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


  $(window).on('load', function (){       
        
      var error_flg = $("#job_information_ledger_error").val();
      if(error_flg == 1){
          // alert("求人表出力時にエラーが発生しました。");
          $(".search-alert-area").addClass('search-alert-area-active');
      }

  });

  $(document).on("click", ".switch_area", function (e) {
    
    var job_id = $(this).data("jobid");
    var publish_flg = $(this).data("publishflg");
    
    var message = "";    

    if (publish_flg == 0) {
      message = "求人情報を公開しますか？";     
    } else {
      message = "求人情報を非公開にしますか？";
    }

    if(!confirm(message)){     
      return false;
    }

    start_processing("#main");

    $.ajax({
            url: "{{ route('recruit_project.job_information_publish_flg_change') }}",
            type: 'post',
            dataType: 'json',
            data: {job_id : job_id , publish_flg : publish_flg},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        })
    // 送信成功
    .done(function (data, textStatus, jqXHR) {
        
        var result_array = data.result_array;

        var Result = result_array["Result"];
        
                     
        end_processing();

        if(Result =='success'){

          $("#switch" + job_id).removeClass("on-class");
          
          if (publish_flg == 0) {
            $("#switch" + job_id).addClass("on-class");
            $("#switch" + job_id).data("publishflg", 1);
          } else{
            $("#switch" + job_id).data("publishflg", 0);
          }

        }else if(Result =='non_session'){

          // 店舗ログイン画面へ
          window.location.href = "{{ route('recruit_project.login') }}";

        }else{          
           

        }

    
    })

    // 送信失敗
    .fail(function (data, textStatus, errorThrown) {
        
      end_processing();
         


    });











    

    

  });

  function job_information_publish_flg_change(job_id , publish_flg) {

   
   
    
   


  }


});

</script>
@endsection


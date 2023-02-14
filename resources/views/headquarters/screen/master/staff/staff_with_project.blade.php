@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'プロジェクト管理')  
@endsection
@section('content')

<div id="main" class="mt-3 text-center container">
   <div class="row">

    @include('headquarters.common.alert')

        <div class="row">        

            <div class="col-6 text-start">
                <h4 class="master_title">
                    プロジェクト管理
                </h4>                
            </div>    

            <div class="col-6 text-end">

                <button type="button" class='original_button'>
                    <a href="{{ route('master.staff') }}">スタッフマスタへ</a>
                </button>
                
            </div>

            <div class="col-12 text-center">
            
                <table class="w-100">
                                    
                    <tr>
                        <th class="text-start">氏名</th>                                
                        <th class="text-start">権限</th>
                        <th></th>
                    </tr>

                    <tr>                                
                        <td class="text-start">
                            <ruby>{{$staff_info->staff_last_name}}　{{$staff_info->staff_first_name}}
                                <rt>{{$staff_info->staff_last_name_yomi}}　{{$staff_info->staff_first_name_yomi}}
                                </rt>
                            </ruby>
                        </td>

                        <td class="text-start">
                            {{$staff_info->authority_name}}
                        </td>

                        <td class="text-end">
                            <button type="button" id='save_button' class="original_button save_button">更新</button>
                        </td>

                    </tr>

                 
                 
                    

                </table>      

            </div>

        </div>
        
        <form id="save_form" method="post" action="{{ route('master.staff_with_project.save') }}"> 
            @csrf

            <input type="hidden" name="staff_id" id="staff_id" value="{{$staff_info->staff_id}}">
            <div id="" class="row">                 
                               
                
                    @foreach ($project_list as $project_list_item)

                        @php
                        
                            $contents = "";
                            $project_id = $project_list_item->project_id;
                            $project_name = $project_list_item->project_name;


                            foreach($staff_with_project_list as $staff_with_project_list_item){ 

                                if($staff_with_project_list_item->project_id == $project_id){
                                    $contents = "checked";
                                }

                            }
                            
                        @endphp

                        <div class="col-6 col-md-4 col-xl-3 p-3 ">
                            <label for="project_id_{{$project_id}}">{{$project_name}}</label>
                            <input type="checkbox" id='project_id_{{$project_id}}' class="" name="project_id_{{$project_id}}" value='1' {{$contents}}>
                        </div>

                    @endforeach           
            
            </div>
        </form>

        {{-- スタッフ情報モーダル --}}
        <div class="modal fade" id="staff_info_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staff_info_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="staff_info_modal_label">専攻情報</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                   
                        <div class="modal-body">                     
            
                            <table class="w-100">
                                
                                <tr>
                                    <th class="text-start">氏名</th>                                
                                    <th class="text-start">権限</th>
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">
                                        <ruby>{{$staff_info->staff_last_name}}　{{$staff_info->staff_first_name}}
                                            <rt>{{$staff_info->staff_last_name_yomi}}　{{$staff_info->staff_first_name_yomi}}
                                            </rt>
                                          </ruby>
                                    </td>

                                    <td class="text-start">　{{$staff_info->authority_name}}</td>
                                </tr>

                                <tr>
                                    <th class="text-start">権限</th>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start">　{{$staff_info->authority_name}}</td>
                                </tr>
                             
                                

                            </table>                            

                        </div>

                        <div class="modal-footer row">            

                            <div id="staff_info_modal_screen_move" class="col-8 m-0 p-0 text-start">
                                
                            </div>

                            <div class="col-4 m-0 p-0 text-end">
                                <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>      
                            </div>                            
                        </div> 

                </div>
            </div>
        </div>

            
        {{-- 備考確認用モーダル --}}
        <div class="modal fade" id="remarks_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="remarks_modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                        <div class="modal-header">
                        <h5 class="modal-title" id=""><span id="remarks_modal_title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">                                                          
                        <textarea id="remarks_modal_remarks" class="form-control" rows="4" cols="40" readonly></textarea>
                    </div>

                    <div class="modal-footer">               
                        <button type="button" id="" class="original_button close_modal_button" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){
    
    
    // 「保存」ボタンがクリックされたら
    $('#save_button').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#save_button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#save_form');

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
                
                var ResultArray = data.ResultArray;

                var Result = ResultArray["Result"];

                if(Result=='success'){

                    location.reload();

                }else{

                    var ErrorMessage = ResultArray["Message"];

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
                    //{{-- ボタン有効 --}}
                    $('#save_button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
                //{{-- アラートメッセージ表示 --}}
                var errorsHtml = '';
                errorsHtml = '<div class="alert alert-danger text-start">';
                errorsHtml += '<li class="text-start">更新失敗</li>';
                errorsHtml += '</div>';

                    //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
                //{{-- ボタン有効 --}}
                $('#save_button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

     

});

</script>
@endsection


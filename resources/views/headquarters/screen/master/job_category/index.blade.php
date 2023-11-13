@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', '職種マスタ')  
@endsection
@section('content')





<div id="main" class="mt-3 text-center container">
    
    
    <div class="row">

    @include('headquarters.common.alert')

    <div class="row m-0 p-0">        

        <div class="col-6 text-start">
            <h4 class="master-title">
                職種大分類マスタ
            </h4>
        </div>    

        <div class="col-6 text-end">

            <button type="button" class='btn btn-link'>
                <a href="{{ route('master.index') }}">マスタ一覧へ</a>
            </button>



            
        </div>

        <div class="col-6 text-start">
            <button type="button" class='btn btn-success search-modal-button' data-bs-toggle='modal' data-bs-target='#search-modal'></button>
        </div>

        <div class="col-6 text-end">
            <button type="button" id="" class="btn btn-primary add-data-button"
                data-bs-toggle='modal' data-bs-target='#job-maincategory-save-modal'            
                data-processflg='0'>
            </button>
        </div>      

    </div>    


    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($job_maincategory_m_list) > 0)                                
          <div class="m-0">{{ $job_maincategory_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>職種大分類CD</th>
                <th>職種大分類名</th>   
                <th>表示順</th>         
                <th>件数【<span id='data-total-count'>{{count($job_maincategory_m_list)}}</span>件】</th>
            </tr>

            @foreach ($job_maincategory_m_list as $item)
                <tr>
                    <td>{{$item->job_maincategory_cd}}</td>
                    <td>{{$item->job_maincategory_name}}</td>
                    <td>{{$item->display_order}}</td>
                    <td>
                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#job-maincategory-save-modal'
                            data-jobmaincategorycd='{{$item->job_maincategory_cd}}'
                            data-jobmaincategoryname='{{$item->job_maincategory_name}}'
                            data-displayorder='{{$item->display_order}}'
                            data-processflg='1'> 
                            <i class='far fa-edit'></i>
                        </button>

                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#job-maincategory-delete-modal'
                            data-jobmaincategorycd='{{$item->job_maincategory_cd}}'
                            data-jobmaincategoryname='{{$item->job_maincategory_name}}'
                            data-displayorder='{{$item->display_order}}'
                            data-deleteflg=@if($item->deleted_at) 1 @else 0 @endif>
                                        
                            @if($item->deleted_at)
                                <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                            @else
                                <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                            @endif
                        </button>             

                    </td>
                </tr>
            @endforeach
        </table>

    </div>



    <div class="row m-0 p-0">        

        <div class="col-6 text-start">
            <h4 class="master-title">
                職種中分類マスタ
            </h4>
        </div>    

        <div class="col-6 text-end">

            <button type="button" class='btn btn-link'>
                <a href="{{ route('master.index') }}">マスタ一覧へ</a>
            </button>



            
        </div>

        <div class="col-6 text-start">
            <button type="button" class='btn btn-success search-modal-button' data-bs-toggle='modal' data-bs-target='#search-modal'></button>
        </div>

        <div class="col-6 text-end">
            <button type="button" id="" class="btn btn-primary add-data-button"
                data-bs-toggle='modal' data-bs-target='#job-subcategory-save-modal'            
                data-processflg='0'>
            </button>
        </div>      

    </div>    


    <div class="m-0 text-start">
        {{-- ページャー --}}                
        @if(count($job_subcategory_m_list) > 0)                                
          <div class="m-0">{{ $job_subcategory_m_list->appends(request()->query())->links() }}</div>
        @endif
    </div>
  

    <div id="" class="scroll-wrap-x m-0">

       
       
        <table id='' class='data-info-table'>
            
            <tr>
                <th>職種大分類</th>                
                <th>職種中分類CD</th>
                <th>職種中分類名</th>
                <th>表示順</th>
                <th>件数【<span id='data-total-count'>{{count($job_subcategory_m_list)}}</span>件】</th>
            </tr>

            @foreach ($job_subcategory_m_list as $item)
                <tr>
                    <td>{{$item->job_maincategory_cd}}:{{$item->job_maincategory_name}}</td>                    
                    <td>{{$item->job_subcategory_cd}}</td>
                    <td>{{$item->job_subcategory_name}}</td>   
                    <td>大[{{$item->job_maincategory_display_order}}]中[{{$item->job_subcategory_display_order}}]</td> 
                    <td>
                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#job-subcategory-save-modal'
                            data-jobmaincategorycd='{{$item->job_maincategory_cd}}'
                            data-jobmaincategoryname='{{$item->job_maincategory_name}}'
                            data-jobsubcategorycd='{{$item->job_subcategory_cd}}'
                            data-jobsubcategoryname='{{$item->job_subcategory_name}}'
                            data-displayorder='{{$item->job_subcategory_display_order}}'
                            data-processflg='1'> 
                            <i class='far fa-edit'></i>
                        </button>

                        <button class='modal-button' data-bs-toggle='modal' data-bs-target='#job_subcategory_delete-modal'
                            data-jobmaincategorycd='{{$item->job_maincategory_cd}}'
                            data-jobmaincategoryname='{{$item->job_maincategory_name}}'
                            data-jobsubcategorycd='{{$item->job_subcategory_cd}}'
                            data-jobsubcategoryname='{{$item->job_subcategory_name}}'
                            data-deleteflg=@if($item->deleted_at) 1 @else 0 @endif>
                                        
                            @if($item->deleted_at)
                                <i class='far fa-thumbs-down'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-up'></i>
                            @else
                                <i class='far fa-thumbs-up'></i><i class='fas fa-arrow-right'></i><i class='far fa-thumbs-down'></i>
                            @endif
                        </button>             

                    </td>
                </tr>
            @endforeach
        </table>

    </div>


   
        {{-- 検索モーダル --}}
        <div class="modal fade" id="search-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="search-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="search-modal-label">検索</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    
                    <form id="search-form" class="" action="" method="get">
                        <div class="modal-body">                     
            
                            <div class="form-group row">                                
                                
                                <label for="search_job_maincategory_name" class="col-12 col-form-label original-label">職種大分類名</label>
                                <select id='search_job_maincategory_cd' name='search_job_maincategory_cd' class='form-control input-sm'>
									<option value=''>
										@foreach($job_maincategory_list as $item)
										<option value="{{$item->job_maincategory_cd}}"
                                        @if($search_element_array['search_job_maincategory_cd'] == $item->job_maincategory_cd)  
                                        selected
                                        @endif  
                                        >
                                            {{$item->job_maincategory_name}}
                                        </option>
										@endforeach
                                </select>

                                <label for="search_job_maincategory_name" class="col-12 col-form-label original-label">職種大分類名（あいまい）</label>
                                <input type="text" id="search_job_maincategory_name" name="search_job_maincategory_name" value="{{$search_element_array['search_job_maincategory_name']}}" class="form-control">

                                <label for="search_job_subcategory_name" class="col-12 col-form-label original-label">職種中分類名（あいまい）</label>
                                <input type="text" id="search_job_subcategory_name" name="search_job_subcategory_name" value="{{$search_element_array['search_job_subcategory_name']}}" class="form-control">
                                                        
                            </div>     
                            
                        </div>

                        <div class="modal-footer">         

                            <div class="col-6 m-0 p-0 text-start">
                                
                                <button type="button" id="" class="btn btn-dark clear-button"></button>
                                <button type="submit" id="" class="btn btn-success search-button"  onclick="return search_form_check();"><i class="fas fa-search"></i></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div>
                    </form>

                </div>
            </div>
        </div>


        {{-- 職種大分類登録/更新用モーダル --}}
        <div class="modal fade" id="job-maincategory-save-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="job-maincategory-save-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="job-maincategory-save-modal-label"><span id="job-maincategory-save-modal-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    <form id="job-maincategory-save-form" method="post" action="{{ route('master.job_maincategory.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="job_maincategory_cd" id="job_maincategory_cd">
                            
                            <div class="form-group row">
                                <label for="job_maincategory_name" class="col-md-6 col-form-label original-label">職種大分類名</label>
                                <input type="text" name="job_maincategory_name" id="job_maincategory_name" value="" class="form-control col-md-3">

                                <label for="job_maincategory_display_order" class="col-md-6 col-form-label original-label">表示順</label>
                                <input type="text" name="job_maincategory_display_order" id="job_maincategory_display_order" value="" class="form-control col-md-3">
                            </div>                     
                            
                        </div>

                        <div class="modal-footer">                            
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="button" id='job-maincategory-save-button' class="btn btn-primary"></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div> 
                        
                    </form>

                </div>
            </div>
        </div>


        {{-- 職種大分類削除用モーダル --}}
        <div class="modal fade" id="job-maincategory-delete-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="job-maincategory-delete-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="job-maincategory-delete-modal-label">操作確認</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="job-maincategory-delete-form" method="post" action="{{ route('master.job_maincategory.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_job_maincategory_flg" name="delete_job_maincategory_flg" value="">
                            <input type="hidden" id="delete_job_maincategory_cd" name="delete_job_maincategory_cd" value="">
                            <input type="hidden" id="delete_job_maincategory_name" name="delete_job_maincategory_name" value="">
            

                            <table class="w-100">

                                <tr>
                                    <td class="text-start">職種大分類CD</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_maincategory_cd"></span></td>
                                </tr>
                             
                                <tr>
                                    <td class="text-start">職種大分類名称</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_maincategory_name"></span></td>
                                </tr>
    
                            </table>           



                        </div>

                        <div class="modal-footer">                                                                                      
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="submit" id='job-maincategory-delete-modal-execution-button' class="btn"></button>                                
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>      
                            </div>                            
                        </div>    
                    </form>

                </div>
            </div>
        </div>





        {{-- 職種中分類類登録/更新用モーダル --}}
        <div class="modal fade" id="job-subcategory-save-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="job-subcategory-save-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="job-subcategory-save-modal-label"><span id="job-subcategory-save-modal-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ajax-msg m-2">
                        
                    </div>
                    
                    <form id="job-subcategory-save-form" method="post" action="{{ route('master.job_subcategory.save') }}">                    
                        @csrf
                        <div class="modal-body">  
                            
                            <input type="hidden" name="job_subcategory_cd" id="job_subcategory_cd">
                            
                            <div class="form-group row">
                                <label for="job_maincategory_cd_for_sub" class="col-md-6 col-form-label original-label">職種大分類名</label>
                               
                                <select id='job_maincategory_cd_for_sub' name='job_maincategory_cd_for_sub' class='form-control input-sm'>
									<option value=''>
										@foreach($job_maincategory_list as $item)
										<option value="{{$item->job_maincategory_cd}}">
                                            {{$item->job_maincategory_name}}
                                        </option>
										@endforeach
                                </select>

                                <label for="job_subcategory_name" class="col-md-6 col-form-label original-label">職種中分類名</label>
                                <input type="text" name="job_subcategory_name" id="job_subcategory_name" value="" class="form-control col-md-3">

                                <label for="job_subcategory_display_order" class="col-md-6 col-form-label original-label">表示順</label>
                                <input type="text" name="job_subcategory_display_order" id="job_subcategory_display_order" value="" class="form-control col-md-3">
                            </div>                     
                     
                            
                        </div>

                        <div class="modal-footer">                            
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="button" id='job-subcategory-save-button' class="btn btn-primary"></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>
                            </div>                            
                        </div> 
                        
                    </form>

                </div>
            </div>
        </div>



        {{-- 職種中分類削除用モーダル --}}
        <div class="modal fade" id="job_subcategory_delete-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="job_subcategory_delete-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="job_subcategory_delete-modal-label">操作確認</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="job_subcategory_delete-form" method="post" action="{{ route('master.job_subcategory.delete_or_restore') }}">                           
                        @csrf
                        <div class="modal-body">  
                            <input type="hidden" id="delete_job_subcategory_flg" name="delete_job_subcategory_flg" value="">
                            <input type="hidden" id="delete_job_subcategory_cd" name="delete_job_subcategory_cd" value="">
                            <input type="hidden" id="delete_job_subcategory_name" name="delete_job_subcategory_name" value="">
            

                            <table class="w-100">

                              
                             
                                <tr>
                                    <td class="text-start">職種大分類名称</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_maincategory_name_for_sub"></span></td>
                                </tr>

                                <tr>
                                    <td class="text-start">職種中分類CD</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_subcategory_cd"></span></td>
                                </tr>

                                <tr>
                                    <td class="text-start">職種中分類名称</td>                                
                                </tr>
    
                                <tr>                                
                                    <td class="text-start"><span id="display_job_subcategory_name"></span></td>
                                </tr>
    
                            </table>           



                        </div>

                        <div class="modal-footer">                                                                                      
                            <div class="col-6 m-0 p-0 text-start">
                                <button type="submit" id='job-subcategory-delete-modal-execution-button' class="btn"></button>
                            </div>

                            <div class="col-6 m-0 p-0 text-end">
                                <button type="button" id="" class="btn btn-secondary modal-close-button" data-bs-dismiss="modal"></button>      
                            </div>                            
                        </div>    
                    </form>

                </div>
            </div>
        </div>
    

    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){

    //職種大分類登録、更新用モーダル表示時
    $('#job-maincategory-save-modal').on('show.bs.modal', function(e) {

        var button_id = "#job-maincategory-save-button";

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var FormData = $("#job-maincategory-save-form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var job_maincategory_cd = evCon.data('jobmaincategorycd');
        var job_maincategory_name = evCon.data('jobmaincategoryname');
        var display_order = evCon.data('displayorder');         

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');
       

        var title ="";

        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
            title = "新規登録処理";
            $(button_id).addClass('insert-button');
            $('#job_maincategory_cd').val(0);
            
        }else{
            title = '更新処理（職種大分類CD：' + job_maincategory_cd+'）';            
            $(button_id).addClass('update-button');
            $('#job_maincategory_cd').val(job_maincategory_cd);
            
        }
        
        $('#job-maincategory-save-modal-title').html(title);    

        $('#job_maincategory_name').val(job_maincategory_name);
        $('#job_maincategory_display_order').val(display_order);
        
    });


    //職種大分類削除モーダル表示時
    $('#job-maincategory-delete-modal').on('show.bs.modal', function(e) {
        // イベント発生元

        var button_id = "#job-maincategory-delete-modal-execution-button";

        let evCon = $(e.relatedTarget);

        var job_maincategory_cd = evCon.data('jobmaincategorycd');
        var job_maincategory_name = evCon.data('jobmaincategoryname');    
        var deleteflg = evCon.data('deleteflg');        

        $(button_id).removeClass('delete-button');
        $(button_id).removeClass('restore-button');
        $(button_id).removeClass('btn-outline-primary');
        $(button_id).removeClass('btn-outline-danger');

        if (deleteflg == 0) {                               
            $(button_id).addClass('btn-outline-danger');
            $(button_id).addClass('delete-button');
            
        } else {                        
            $(button_id).addClass('btn-outline-primary');
            $(button_id).addClass('restore-button');
        }

       
    
        $('#display_job_maincategory_cd').html(job_maincategory_cd);    
        $('#display_job_maincategory_name').html(job_maincategory_name);    

        $('#delete_job_maincategory_flg').val(deleteflg);
        $('#delete_job_maincategory_cd').val(job_maincategory_cd);
        $('#delete_job_maincategory_name').val(job_maincategory_name);  

    });




    //職種中分類登録、更新用モーダル表示時
    $('#job-subcategory-save-modal').on('show.bs.modal', function(e) {


        var button_id = "#job-subcategory-save-button";

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        var FormData = $("#job-subcategory-save-form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });

        // イベント発生元
        let evCon = $(e.relatedTarget);

        var job_maincategory_cd = evCon.data('jobmaincategorycd');        
        var job_subcategory_cd = evCon.data('jobsubcategorycd');
        var job_subcategory_name = evCon.data('jobsubcategoryname');
        var display_order = evCon.data('displayorder');

        var title ="";

        $(button_id).removeClass('insert-button');
        $(button_id).removeClass('update-button');        


        //登録処理か更新処理か判断
        var processflg = evCon.data('processflg');
        if(processflg == '0'){
             title = "新規登録処理";
            $('#job_subcategory_cd').val(0);
            $(button_id).addClass('insert-button');
        }else{            
            title = '更新処理（職種中分類CD：' + job_subcategory_cd+'）';
            $('#job_subcategory_cd').val(job_maincategory_cd);
            $(button_id).addClass('update-button');
        }


        $('#job-subcategory-save-modal-title').html(title);            

        $('#job_maincategory_cd_for_sub').val(job_maincategory_cd);        
        $('#job_subcategory_name').val(job_subcategory_name);
        $('#job_subcategory_display_order').val(display_order);

    });


    //職種中分類削除モーダル表示時
    $('#job_subcategory_delete-modal').on('show.bs.modal', function(e) {
        
        var button_id = "#job-subcategory-delete-modal-execution-button";
        // イベント発生元        
        let evCon = $(e.relatedTarget);

        var job_maincategory_name = evCon.data('jobmaincategoryname');
        var job_subcategory_cd = evCon.data('jobsubcategorycd');
        var job_subcategory_name = evCon.data('jobsubcategoryname');        
        

        var deleteflg = evCon.data('deleteflg');        

        $(button_id).removeClass('delete-button');
        $(button_id).removeClass('restore-button');
        $(button_id).removeClass('btn-outline-primary');
        $(button_id).removeClass('btn-outline-danger');

        if (deleteflg == 0) {                               
            $(button_id).addClass('btn-outline-danger');
            $(button_id).addClass('delete-button');
            
        } else {                        
            $(button_id).addClass('btn-outline-primary');
            $(button_id).addClass('restore-button');
        }

       
    
        $('#display_job_maincategory_name_for_sub').html(job_maincategory_name);    
        $('#display_job_subcategory_cd').html(job_subcategory_cd);           


        $('#delete_job_subcategory_flg').val(deleteflg);
        $('#delete_job_subcategory_cd').val(job_subcategory_cd);
        $('#delete_job_subcategory_name').val(job_subcategory_name);  

    });


    // 「クリア」ボタンがクリックされたら
    $('.clear-button').click(function () {

        var FormData = $("#search-form").serializeArray();        

        $.each(FormData, function(i, element) {		
            $("[name='"+ element.name +"']").val("");          
        });
    });


    // 職種大分類「保存」ボタンがクリックされたら
    $('#job-maincategory-save-button').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#job-maincategory-save-button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#job-maincategory-save-form');

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

                if(Result=='success'){

                    location.reload();

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
                    //{{-- ボタン有効 --}}
                    $('#job-maincategory-save-button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
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
                    errorsHtml += '<li class="text-start">登録処理エラー</li>';

                }

                errorsHtml += '</div>';
                
                //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
                //{{-- ボタン有効 --}}
                $('#job-maincategory-save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });



    // 職種中分類「保存」ボタンがクリックされたら
    $('#job-subcategory-save-button').click(function () {
     
        // ２重送信防止
        // 保存tを押したらdisabled, 10秒後にenable
        $(this).prop("disabled", true);

        setTimeout(function () {
            $('#job-subcategory-save-button').prop("disabled", false);
        }, 3000);

        //{{-- メッセージクリア --}}
        $('.ajax-msg').html('');
        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        let f = $('#job-subcategory-save-form');

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

                if(Result=='success'){

                    location.reload();

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
                    //{{-- ボタン有効 --}}
                    $('#job-subcategory-save-button').prop("disabled", false);
                    //{{-- マウスカーソルを通常に --}}                    
                    document.body.style.cursor = 'auto';

                }

            
            })

            // 送信失敗
            .fail(function (data, textStatus, errorThrown) {
                
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
                    errorsHtml += '<li class="text-start">登録処理エラー</li>';

                }

                errorsHtml += '</div>';
                
                //{{-- アラート --}}
                $('.ajax-msg').html(errorsHtml);
                //{{-- 画面上部へ --}}
                $("html,body").animate({
                    scrollTop: 0
                }, "300");
                //{{-- ボタン有効 --}}
                $('#job-subcategory-save-button').prop("disabled", false);
                //{{-- マウスカーソルを通常に --}}                    
                document.body.style.cursor = 'auto';

            });

    });

});

</script>
@endsection


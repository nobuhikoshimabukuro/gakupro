@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'マスタ一覧')  
@endsection
@section('content')

<style>
     
    
    
</style>

<div id="main"class="mt-3 text-center container">
    <div class="row">
       
      

       
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.maincategory') }}">
              
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-th-list fa-3x mb-1"></i>                    
                    <h6>大分類マスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.subcategory') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-th fa-3x mb-1"></i>                    
                    <h6>中分類マスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.project') }}">
              
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fab fa-product-hunt fa-3x mb-1"></i>                    
                    <h6>プロジェクトマスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.school') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-school fa-3x mb-1"></i>
                    <h6>学校マスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.majorsubject') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-book-open fa-3x mb-1"></i>
                    <h6>専攻マスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.staff') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-people-carry fa-3x mb-1"></i>
                    <h6>スタッフマスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.member') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="far fa-id-card fa-3x mb-1"></i>
                    <h6>メンバーマスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.address') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-street-view fa-3x mb-1"></i>
                    <h6>住所マスタ</h6>
                </div>
            </a>
        </div>

        {{-- <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.employer') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-school fa-3x mb-1"></i>
                    <h6>会社マスタ</h6>
                </div>
            </a>
        </div> --}}
       
       
        
        
        </div>
    </div>
</div>
@endsection

@section('pagejs')

<script type="text/javascript">

$(function(){





});

</script>
@endsection


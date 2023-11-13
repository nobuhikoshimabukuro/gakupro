@extends('headquarters.common.layouts_afterlogin')

@section('pagehead')
@section('title', 'マスタ一覧')  
@endsection
@section('content')

<style>
     
    .partition-area{
        width: 100%;
        background-color: rgb(190, 196, 196);
        color: rgb(51, 6, 6);
        font-size: 25px;
        font-weight: bold;        
    }
    
</style>

<div id="main"class="mt-3 text-center container">

    <div class="row">
       
        <div class="col-6 col-md-4 col-xl-3 p-3 ">
            <a href="{{ route('master.category') }}">
              
                <div class="bg-dark rounded-lg text-light p-2 ">
                    <i class="fas fa-th-list fa-3x mb-1"></i>                    
                    <h6>分類マスタ</h6>
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

        <div class="col-12 m-0 p-0">

            <div class="row m-0 p-0">

                <div class="partition-area">
                    求人関連
                </div>
            
            </div>
            
        </div>


        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-user-secret fa-3x mb-1"></i>
                    <h6>雇用者マスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.salary_category') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="far fa-money-bill-alt fa-3x mb-1"></i>
                    <h6>給与マスタ</h6>
                </div>
            </a>
        </div>


        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.job_category') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-sitemap fa-3x mb-1"></i>
                    <h6>職種マスタ</h6>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.job_supplement') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="far fa-check-square fa-3x mb-1"></i>
                    <h6>求人条件マスタ</h6>
                </div>
            </a>
        </div>


        <div class="col-6 col-md-4 col-xl-3 p-3">
            <a href="{{ route('master.job_password') }}">
                <div class="bg-dark rounded-lg text-light p-2 ">                    
                    <i class="fas fa-passport fa-3x mb-1"></i>
                    <h6>求人公開パスワード</h6>
                </div>
            </a>
        </div>


       
        
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


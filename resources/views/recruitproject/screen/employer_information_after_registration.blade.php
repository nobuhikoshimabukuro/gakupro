@extends('recruitproject.common.layouts_beforelogin')

@section('pagehead')
@section('title', '登録完了')  
@endsection
@section('content')

<style>
    
    #ApprovaCheckBox {
        transform: scale(2);	
        margin: 15px;
    }

</style>
<div class="mt-3 text-center container">
    
    <div id="" class="row m-0 p-0">   
    
        <h2>
            <ruby>
                <rb>{{$employer_info->employer_name}}</rb>
                <rp>
                  （</rp><rt>{{$employer_info->employer_name_kana}}</rt><rp>）
                </rp>
            </ruby>
             様
        </h2>

        <h2>
            雇用者情報のご登録をありがとうございます。<br>
            下記のログインIDとパスワードを必ず控えてください。<br>
            次回からログイン時に必要となります。            
        </h2>

        <h2>
            ログインID：{{$employer_info->login_id}}<br>
            パスワード：{{$employer_info->password}}
        </h2>

        <input type="hidden" id="login_id" class="form-control" value="{{$employer_info->login_id}}">
        <input type="hidden" id="password" class="form-control" value="{{$employer_info->password}}">


        <h2>            
            <button type="button" id="CopyButton" class="btn btn-primary">ログイン情報をコピー<i class="far fa-edit"></i></button>
            {{-- <br>                      
            ※お使いの端末でコピー機能が作動しない可能性がありますので必ず確認をお願い致します。 --}}
        </h2>

        <div id="" class="">    
            ログイン情報を控えました<input type="checkbox" id="ApprovaCheckBox" name="">
        </div>

        

        <div id="ScreenTransition" class="d-none">        
            <h2><a href="{{route('recruitproject.employer_top')}}" rel="noopener noreferrer">TOP画面に遷移する</a></h2>                                  
        </div>

    </div>
    
    
</div>
@endsection

@section('pagejs')
<script src="{{ asset('js/common.js') }}"></script>
<script type="text/javascript">

$(function(){

    //コピーボタンクリック時
    $('#CopyButton').click(function () {    

         // テキストエリアのテキストを取得（コピーさせるテキスト）
        var login_id = $('#login_id').val();
        var password = $('#password').val();

        var text = "ログインID：" + login_id + "\n" + "パスワード：" + password;
        // コピーする媒体となるテキストエリアを生成
        var clipboard = $('<textarea></textarea>');
        clipboard.text(text);
        // body直下に一時的に挿入
        $('body').append(clipboard);
        // 選択状態にする
        clipboard.select();
        // WebExtension APIのブラウザ拡張の仕組みを呼び出しクリップボードにコピー
        document.execCommand('copy');
        // 不要なテキストエリアを削除
        clipboard.remove();
        // 通知
        alert('クリップボードにコピーしました');

    });

    //承認チェックボックスの変更時
    $('#ApprovaCheckBox').change(function(){

        $("#ScreenTransition").removeClass("d-none");

        if(!$(this).prop('checked') ){

            $("#ScreenTransition").addClass("d-none");
          
        }

    });

});

</script>
@endsection


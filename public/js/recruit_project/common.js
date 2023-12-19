function end_loader() {

  var elements = document.querySelectorAll('.loader-area');

  // 取得した要素を削除
  elements.forEach(function(element) {
    element.remove();
  });


  var elements = document.querySelectorAll('.loader');

  // 取得した要素を削除
  elements.forEach(function(element) {
    element.remove();
  });
}

// 引数は操作制御したいセレクタ
function start_processing(target){

  // 処理中のローディングcss
  let Html = '<div class="processing-area">';
  Html += '<div class="processing"></div>';
  Html += '</div>';

  // 対象要素に作成したhtmlを追加
  $(Html).appendTo(target);


}

function end_processing(){   


  var elements = document.querySelectorAll('.processing-area');

  // 取得した要素を削除
  elements.forEach(function(element) {
    element.remove();
  });


  var elements = document.querySelectorAll('.processing');

  // 取得した要素を削除
  elements.forEach(function(element) {
    element.remove();
  });

}

// 引数は操作制御したいセレクタ
function alert_display(target , message){



  // 処理中のローディングcss
  let Html = '<div class="alert-area">';
  Html += message;
  Html += '</div>';

  // 対象要素に作成したhtmlを追加
  $(Html).appendTo(target);

  $('.alert-area').fadeIn()

}


function alert_reset(){

  var elements = document.querySelectorAll('.alert-area');

  // 取得した要素を削除
  elements.forEach(function(element) {
    element.remove();
  });

}

// ドロップダウンメニューを閉じない
$(document).on('click', '.dropdown-menu', function(e) {
  if ($(this).hasClass('keep-open-on-click')) { e.stopPropagation(); }
});

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
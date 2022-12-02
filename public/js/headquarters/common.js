
// ドロップダウンメニューを閉じない
$(document).on('click', '.dropdown-menu', function(e) {
  if ($(this).hasClass('keep-open-on-click')) { e.stopPropagation(); }
});


function phpProcessingStart() {         

  //マウスを待機中
  document.body.style.cursor = 'wait';  
  //発火元（主にボタン）を操作不可にする
  $(this).prop("disabled", true);
}

function phpProcessingEnd() {

  //マウスを待機中から解除
  document.body.style.cursor = 'auto';

  //発火元（主にボタン）を操作可能にする
  $(this).prop("disabled", false);

}


function LoaderEnd() {
  $(".InoperableClass").removeClass('InoperableClass');
  $("#LoadingArea").remove(); 
}

function UploaderStart() {
  $("#Main").addClass('InoperableClass');
  $("#UploadingArea").removeClass('d-none');  
}

function UploaderEnd() {
  $("#UploadingArea").addClass('d-none');  
  $("#Main").removeClass('InoperableClass');  
}




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
  $(".inoperable_class").removeClass('inoperable_class');
  $("#loading_area").remove(); 
}

function UploaderStart() {
  $("#main").addClass('inoperable_class');
  $("#uploading_area").removeClass('d-none');  
}

function UploaderEnd() {  
  $("#uploading_area").remove();
  $("#main").removeClass('inoperable_class');  
}


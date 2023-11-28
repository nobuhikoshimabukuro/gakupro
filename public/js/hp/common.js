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


function start_processing() {

  

}


function end_processing() {

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
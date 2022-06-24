(function(){
  const btnDel = document.querySelector('#btnDel');
  // const i_board = new URLSearchParams(location.search).get('i_board');
  btnDel.addEventListener('click', function(){
    if(confirm('삭제하시겠습니까?')){
      location.href = `del?i_board=${btnDel.dataset.i_board}&i_user=${btnDel.dataset.i_user}`;
    }
  });

  

})();
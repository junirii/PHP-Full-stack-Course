(function(){
  const trList = document.querySelectorAll('tbody > tr');

  //dataset 사용방법 알기 예시
  // const tr1 = trList[1];
  // console.log(tr1.dataset.i_board);

  trList.forEach(function(item){
    const i_board = item.dataset.i_board;
    item.addEventListener('click', function(){
      location.href = `detail?i_board=${i_board}`;
    });
  });
})();
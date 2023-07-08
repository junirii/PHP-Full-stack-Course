<div>
  <?php 
  if(isset($_SESSION[_LOGINUSER])){
    print $_SESSION[_LOGINUSER]->nm . "님, 환영합니다!"
  ?>
    <a href="/board/write"><button>글쓰기</button></a>
    <a href="/board/list"><button>리스트</button></a>
    <a href="/user/logout"><button>로그아웃</button></a>
  <?php 
  }else{
    print 
    " <script>
      alert('로그인 해주세요.');
      location.href='/user/login';
      </script>
    ";
    return;
  }
  ?>
</div>
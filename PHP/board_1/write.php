<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>글쓰기</title>
</head>
<body>
  <h1>글쓰기</h1>
  <a href="list.php"><button>리스트</button></a>
  <form action="write_proc.php" method="post" enctype="multipart/form-data">
    <div><input type="text" name="title" spaceholder="제목"></div>
    <div><textarea name="ctnt" spaceholder="내용"></textarea></div>
    <input type="submit" value="글 등록">
    <input type="reset" value="초기화">    
  </form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <form method="post" action="client.php">    
        <input type="text" name="msg" id="msg">
        <input type="submit" name="btnSend" value="send" id="btnSend">
    </form>
    <div id="chat"></div>
    <?php
     $host = gethostbyname("localhost");
     $port = 20211;

     $reply = "";
     if(isset($_POST["btnSend"])) {
         $msg = $_POST["msg"];
         $sock = socket_create(AF_INET, SOCK_STREAM, 0);
         socket_connect($sock, $host, $port);
         socket_write($sock, $msg, strlen($msg));

         $reply = socket_read($sock, 1024);
         $reply = "server says:\t" . trim($reply) . "<br>";
     }     
    ?>
    <div><?=$reply?></div>
    <script>
        const name = prompt('당신의 이름은?');
        const inputMsg = document.querySelector('#msg');
        const btnSend = document.querySelector('#btnSend');
        const divChat = document.querySelector('#chat');
        btnSend.addEventListener('click', function(){
            const msg = inputMsg.value;
            const divMsg = divChat.appendChild(document.createElement('div'));
            divMsg.innerText = msg;
        });
        
    </script>
</body>
</html>
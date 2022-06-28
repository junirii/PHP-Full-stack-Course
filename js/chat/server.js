const express = require('express');
const socket = require('socket.io');
const http = require('http');
const fs = require('fs');
const exp = require('constants');
const app = express();
const server = http.createServer(app);
const io = socket(server);

app.use('/css', express.static('./static/css'));
app.use('/js', express.static('./static/js'));

app.get('/', function(request, response){
  fs.readFile('./index.html', function(err, data){
    if(err){
      response.send('에러');
    }else{
      response.writeHead(200, {'Content-Type':'text/html'});
      response.write(data);
      response.end();
    }
  })
});

let userList = [];
let num = 1;
io.sockets.on('connection', function(socket){
  socket.on('newUser', function(name){
    console.log(name + '님이 접속하였습니다.');
    socket.name = name;
    socket.uid = num++;
    io.sockets.emit('update', {type: 'connect', name: 'SERVER', message: name + '님이 접속하였습니다.'});
    
    userObj = {
      'uid': socket.uid,
      'name': name
    };
    socket.emit('newUser', userObj);

    userList.push(userObj);
    io.sockets.emit('users', userList);
    console.log(userList);
  });

  socket.on('message', function(data){
    data.name = socket.name;
    console.log(data);
    socket.broadcast.emit('update', data);
  });

  socket.on('disconnect', function(){
    console.log(socket.name + '님이 나가셨습니다.');
    socket.broadcast.emit('update', {type: 'disconnect', name: 'SERVER', message: socket.name + '님이 나가셨습니다.'});

    userList = userList.filter(function(item){
      return item.uid !== socket.uid;
    });
    io.sockets.emit('users', userList);
    console.log(userList);
  });
});

server.listen(8080, function(){
  console.log('서버 실행 중...');
});
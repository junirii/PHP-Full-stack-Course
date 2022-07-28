const express = require('express');
const app = express();
const http = require('http').createServer(app);
const port = process.env.PORT || 3000;
const path = require("path");

//setting cors 
// 없애도 됨
// app.all('/*', function(req, res, next) {
//     res.header("Access-Control-Allow-Origin", "*");
//     res.header("Access-Control-Allow-Headers", "X-Requested-With");
//     next();
// });

app.use(express.static('./public'));

// 위 코드 때문에 쓸모 x
app.get('/index', (req, res) => {
    res.sendFile(path.join(__dirname, './public', 'index.html'));
});

app.get('/test', (req, res) => {
    const arr = [
        {
            name: '홍길동',
            age: 11
        }
    ];
    res.json(arr);
});


const server = http.listen(port, () => {
    console.log(`server is listening at localhost:${port}`);
});

const socketIO = require('socket.io');

const io = socketIO(server, { path: '/socket.io'});
io.on('connection', (socket) => {
    console.log('a user connected');
    socket.on('msg', (msg) => {
      io.emit('msg', msg);
    });
    socket.on('disconnect', reason => {
        console.log(reason);
        console.log('user disconnected');
    });
  });
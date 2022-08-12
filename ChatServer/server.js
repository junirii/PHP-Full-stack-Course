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

// const userList = {};
const io = socketIO(server, { path: '/socket.io'});
io.on('connection', async (socket) => {
    socket.on('newUser', (data) => {
        socket.name = data.nick;
        socket.id = data.id;
        const room = data.itravel;
        console.log(room);
        socket.join(room);
        // if(userList[room] && userList[room].length > 0){
        //     userList[room].forEach(item => {
        //         if(item.id !== socket.id){
        //             userList[room].push({
        //                 id: socket.id,
        //                 nick: socket.name,
        //             });
        //         }
        //     });
        // }else{
        //     userList[room] = [{
        //         id: socket.id,
        //         nick: socket.name,
        //     }];
        // }
        // console.log(userList);
        console.log(`${socket.name}님이 ${room}번방에 입장하셨습니다.`);
        // io.to(room).emit('update', {
        //     type: 'connect',
        //     name: 'SERVER',
        //     msg: `${socket.name}님이 입장하셨습니다.`
        // });
        // io.to(room).emit('users', userList);

        socket.emit('enterRoom', {
            unreadCntAll: data.unreadCntAll
        });

        socket.on('msg', (msg) => {
            console.log(msg);
            socket.broadcast.to(room).emit('update', msg);
        });
        
        socket.on('disconnect', reason => {
            console.log(reason);
            console.log(`${socket.name}님이 퇴장하셨습니다.`);
        //     io.to(room).emit('update', {
        //         type: 'disconnect',
        //         name: 'SERVER',
        //         msg: `${socket.name}님이 퇴장하셨습니다.`
        //     });
        //     userList[room] = userList[room].filter(item => {
        //         return item.id !== socket.id;
        //     });
        //     io.to(room).emit('users', userList);
        });
    });

  });
import io from "socket.io-client";

const socket = io.connect("http://192.168.0.62:3000", {
    path: '/socket.io',
    transports: ['websocket']
});

const socketPlugin = { //전역으로 소켓 쓸 수 있게 세팅
  install: (app, options) => {
    app.config.globalProperties.$socket = socket;
  },
};

export default socketPlugin;

<template>
    <div> 
        <input type="hidden" id="inputChat" value="0">
        <h1>Chat</h1>
        <div id="main">
            <div id="users">
                {{myInfo.nick}} (나)
                <span v-for="item in chatUser" :key="item.iuser">
                    <span v-if="item.iuser !== myInfo.iuser">
                        | {{item.nick}} 님
                    </span>
                </span>
            </div>
            <hr>
            <div id="chat">
                <div v-for="(item, idx) in chatList" :key="idx">
                <div id="other" v-if="item.name !== myInfo.nick">
                {{ item.name }} : {{ item.msg }}
                </div>
                <div id="me" v-if="item.name === myInfo.nick">
                    {{item.msg}}
                </div>
                </div>
            </div>
            <div id="input">
                <input type="text" v-model="input" @keypress="enter($event);">
                <button @click="sendMsg">전송</button>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            myInfo: {
                id: null,
                nick: null,
                iuser: this.$store.state.user.iuser
            },
            input: '',
            chatList: [],
            // userList: [],
            itravel: null,
            chatUser: []
        }
    },
    created() {
        this.itravel = this.$route.query.itravel;
        this.$store.state.itravel = this.itravel;
        this.selChat(this.itravel);
        this.socketId = this.$socket.id;
        this.myInfo.id = this.socketId;
        this.myInfo.nick = this.$store.state.user.nick;
        if(this.$store.state.unreadCnt[this.itravel]){
            this.$store.state.unreadCntAll -= this.$store.state.unreadCnt[this.itravel];
        }
        this.$store.state.unreadCnt[this.itravel] = 0;
        this.$socket.emit('newUser', {
            id: this.myInfo.id,
            nick: this.myInfo.nick,
            itravel: this.itravel,
            unreadCntAll: this.$store.state.unreadCntAll
        });
        // this.$socket.on('users', userList => {
        //     this.userList = userList[this.itravel];
        //     console.log(this.userList);
        // });
        this.$socket.on('update', data => {
            const inputChat = document.querySelector('#inputChat');
            if(inputChat && data.room === this.itravel){
                this.chatList.push(data);
                // const chat = document.querySelector('#chat');
                // chat.scrollTop = chat.scrollHeight;
            }
        });


    },
    updated(){
        const chat = document.querySelector('#chat');
        chat.scrollTop = chat.scrollHeight;
    },
    methods: {
        async sendMsg() {
            if(this.input){
                this.$socket.emit('msg', {
                    msg: this.input,
                    name: this.myInfo.nick,
                    room: this.itravel
                });
                const data = {
                    msg: this.input,
                    name: this.myInfo.nick
                };
                this.chatList.push(data);
                const res = await this.$post('/chat/insChatMsg', {
                    itravel: this.itravel,
                    iuser: this.$store.state.user.iuser,
                    msg: this.input
                });
                console.log(res);
                if(res.result === 1){
                    this.input = '';
                }
                const chat = document.querySelector('#chat');
                chat.scrollTop = chat.scrollHeight;
            }
        },
        enter(e){
            if(e.keyCode === 13){
            this.sendMsg();
            }
        },
        async selChat(itravel){
            const res = await this.$get(`/chat/selChatList/${itravel}`);
            console.log(res);
            this.chatList = res.result.chatList;
            this.chatUser = res.result.chatUser;
            console.log(this.chatList);
            console.log(this.chatUser);
        },
    }
}
</script>

<style scoped>
#main{
    margin: auto;
    margin-top: 100px;
    border-radius: 20px;
    border: blue 1px solid;
    text-align: center;
    width: 500px;
    height: 500px;
    position: relative;
}
#chat {
    height: 90%;
    width: 100%;
    overflow-y: auto;
    padding: 20px;
}
#other {
    text-align: left;
}
#me {
    text-align: right;
}
hr {
    height: 2px;
    color: var(--maincolor);
    width: 70%;
    margin: 0 auto;
}
</style>
<template>
    <div class="chat"> 
        <input type="hidden" id="inputChat" value="0">
        <h2 class="bolder" style="color: var(--maincolor);">{{ travelTitle }}</h2>
        <div id="main">
            <div id="users" class="bolder">
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
                    <div class="your-chat">
                        <p id="you" v-if="item.name !== myInfo.nick">
                            {{ item.name }}
                        </p>
                        <!-- <div class="profile">
                            <img class="profile-img" v-if="this.$store.state.isLogin"
                                :src="`/static/img/profile/${this.$store.state.user.iuser}/${this.$store.state.user.profile_img}`"
                                style="width:30px; height: 30px; object-fit: cover;">
                        </div> -->
                        <div class="your-msg" v-if="item.name !== myInfo.nick">
                            <p class="your-msg-ctnt">{{ item.msg }}</p>
                        </div>
                    </div>
                    <div id="me" v-if="item.name === myInfo.nick">
                        <p class="my-msg-ctnt"> {{item.msg}} </p>
                    </div>
                </div>
            </div>
            <div id="input">
                <input type="text"
                       v-model="input"
                       placeholder="메세지를 입력하세요."
                       @keypress="enter($event);">
                <button class="submit-btn" @click="sendMsg">전송</button>
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
            chatUser: [],
            travelTitle: null
        }
    },
    created() {
        this.itravel = this.$route.query.itravel;
        this.$store.state.itravel = this.itravel;
        this.socketId = this.$socket.id;
        this.myInfo.id = this.socketId;
        this.myInfo.nick = this.$store.state.user.nick;
        if(this.$route.query.isnew){
            this.enterMsg();
        }
        this.selChat(this.itravel);
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
        this.getTravelData();

    },
    updated(){
        const chat = document.querySelector('#chat');
        chat.scrollTop = chat.scrollHeight;
    },
    methods: {
        // setDefaultImg() {
        //     document.querySelector('#profile-img').src = '/static/img/profile/common/defaultImg.webp';
        // },
        async enterMsg(){
            const res = await this.$post('/chat/insChatMsg', {
                itravel: this.itravel,
                iuser: 0,
                msg: `${this.myInfo.nick}님이 입장하셨습니다.`
            });
            console.log(res);
        },
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
        async getTravelData(){
            const itravel = this.itravel;
            const res = await this.$get(`/travel/getTravelData/${itravel}`);
            if(res.result){
                this.travelTitle = res.result.title;
                console.log(this.travelTitle);
            }
        }
    }
}
</script>

<style scoped>
/* 전체 화면 */
.chat { 
    z-index: auto;
    margin: 0 auto;
    padding: 150px;
}
/* 채팅창 */
#main{
    margin: auto;
    margin-top: 50px;
    border-radius: 20px;
    border: var(--mainOrange) 1px solid;
    text-align: center;
    width: 500px;
    height: 500px;
    position: relative;
}
#users {
    color: var(--mainOrange);
    padding: 15px;
}
#users > div {
    margin-right: 10px;
}
#chat {
    display: flex;
    flex-direction: column;
    height: 80%;
    width: 90%;
    margin: 0 auto;
    overflow-y: auto;
    padding: 20px;
}
#you {
    font-size: 14px;
    font-weight: 700;
    color: var(--mainOrange);
    margin-top: 0;
    margin-block-end: 0rem;
}
.your-chat {
    display: flex;
}
.your-msg {
    display: flex;
    align-items: flex-end;
    line-break: anywhere;
}
.your-msg-ctnt {
    text-align: left;
    margin: 0.4rem 1rem 0 0;
    border-radius: 0px 20px 20px 20px;
    background-color: #f3f3f3;
    max-width: 180px;
    color: var(--mainOrange);
    padding: 0.8rem;
    font-size: 14px;
}
#me {
    display: flex;
    justify-content: right;
    align-items: flex-end;
    margin: 0;
    min-height: 40px;
    line-break: anywhere;
}
.my-msg-ctnt {
    text-align: left;
    margin: 0.4rem 0 0 1rem;
    border-radius: 20px 20px 0px 20px;
    max-width: 180px;
    background-color: var(--mainOrange);
    color: #fff;
    padding: 0.8rem;
    font-size: 14px;
}
hr {
    height: 2px;
    color: var(--mainOrange);
    width: 90%;
    margin: 0 auto;
}
#input {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem;
    border: 1px solid var(--mainOrange);
    background: #fff;
    color: var(--mainOrange);
    border-radius: 0px 0px 24px 24px;
    font-weight: bolder;
}
input {
    border: none;
    padding: 0.5rem;
    font-size: 16px;
    width: 500px;
    background-color: #fff;
    color: var(--mainOrange);
    font-weight: bolder;
}
input:focus {
    outline: none;
}
.submit-btn {
    display: flex;
    align-items: center;
    cursor: pointer;
    border: 2px solid var(--mainOrange);
    background-color: #fff;
    font-family: 'LeferiPoint-WhiteA';
    font-weight: bolder;
    width: 50px;
    border-radius: 15px;
    padding: 5px;
    color: var(--mainOrange);
}
</style>
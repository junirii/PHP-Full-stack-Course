<template>
    <div class="create_box"></div>
  <div> 
        <h1>Chat</h1>
        <div>
            {{myInfo.nick}} (나)
            <span v-for="item in userList" :key="item.id">
                <span v-if="item.id !== myInfo.id">
                    | {{item.nick}} 님
                </span>
            </span>
        </div>
        <hr>
        <div v-for="(item, idx) in chatList" :key="idx">
          <div v-if="item.name">
          {{ item.name }} : {{ item.msg }}
          </div>
          <div v-if="!item.name">
            {{item.msg}}
          </div>
        </div>
        <div>
            <input type="text" v-model="input" @keypress="enter($event);"><button @click="sendMsg">전송</button>
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
            },
            input: '',
            chatList: [],
            userList: [],
            itravel: null
        }
    },
    created() {
        this.itravel = this.$store.state.itravel;
        this.socketId = this.$socket.id;
        this.myInfo.id = this.socketId;
        this.myInfo.nick = this.$store.state.user.nick
        this.$socket.emit('newUser', {
            id: this.myInfo.id,
            nick: this.myInfo.nick,
            itravel: this.itravel
        });
        this.$socket.on('users', userList => {
            this.userList = userList[this.itravel];
            console.log(this.userList);
        });
        this.$socket.on('update', data => {
            this.chatList.push(data);
        });
        
    },
    methods: {
        sendMsg() {
            this.$socket.emit('msg', {
                msg: this.input,
                name: this.myInfo.nick
            });
            const data = {
                msg: this.input
            };
            this.chatList.push(data);
            
            this.input = '';
        },
        enter(e){
            if(e.keyCode === 13){
            this.sendMsg();
    }
        }
    }
}
</script>

<style>

</style>
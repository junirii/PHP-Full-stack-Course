<template>
    <div class="create_box"></div>
  <div> 
        <h1>Chat</h1>
        <div v-for="(item, idx) in chatList" :key="idx">
          {{ item.name }} : {{ item.msg }}
        </div>
        <div>
            <input type="text" v-model="input"><button @click="sendMsg">전송</button>
        </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            input: '',
            chatList: []
        }
    },
    created() {       
        this.socketId = this.$socket.id;
        this.$socket.on('msg', data => {
            this.chatList.push(data);
        });
        this.$socket.emit('newUser', {
            nick: this.$store.state.user.nick
        });
        this.$socket.on('newUser', nick => {
            const data = {
                name: 'SERVER',
                msg: nick + '님이 입장하셨습니다.'
            }
            this.chatList.push(data);
        });
        
    },
    methods: {        
        sendMsg() {
            this.$socket.emit("msg", {
                msg: this.input,
                name: this.$store.state.user.nick
            });
            this.input = '';
        }
    }
}
</script>

<style>

</style>
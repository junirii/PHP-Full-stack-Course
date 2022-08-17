<template>
  <body>
    <div class="setting-btn">
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin"
              @click="loginCheck('Create')">여행 만들기</button>
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin"
              @click="loginCheck('SelectPage')">여행 찾기</button>
    </div>
      <button class="main-btn join-btn" type="button" v-if="!this.$store.state.isLogin" @click="showModal">들어가기</button>
    <LoginModal :show="modalShow" @close="hiddenModal" v-on:update="onLogin" />
  </body>
</template>

<script>
import LoginModal from '/src/components/common/LoginModal.vue';

export default {
  name: 'Home',
  data(){
    return {
      modalShow: false,
    };
  },
  components: {
    LoginModal
  },
  created(){
    if(this.$store.state.user){
      this.$store.state.isLogin = true;
    }
    console.log(this.$store.state.user);
    this.$store.state.filter = {};
  },
  methods: {
    showModal(){
      this.modalShow = true;
    },
    hiddenModal(){
      this.modalShow = false;
    },
    onLogin(){
      this.$store.state.isLogin = true;
    },
    loginCheck(path){
      if(this.$store.state.isLogin === true){ //로그인 o 경우
        this.$router.push({path: `/${path}`}); //라우터 주소 이동
      }
    }
  }
}
</script>

<style scoped>
body {
  z-index: auto;
  height: 100vh;
  width: 100vw;
  background-repeat : no-repeat;
  background-size : cover;
  background-image: url('../../static/img_used/main.png');
  background-position-y: -100px;
}
* {
  margin: 0;
}

html {
  font-size: 16px;
  font-family: 'LeferiPoint-WhiteA';
}
.setting-btn {
  text-align: center;
  position: absolute;
  bottom: 510px;
  left: 810px;
}
.join-btn {
  text-align: center;
  position: absolute;
  bottom: 510px;
  left: 890px;
}
.main-btn { 
  font-family: 'LeferiPoint-WhiteA';
  display: inline-block;
  text-decoration: none;
  background: #fff;
  padding: 8px 15px;
  border-radius: 7px;
  font-weight: bold;
  color: var(--mainOrange);
  box-shadow: 0 8px 0 var(--mainDarkOrange);
  transition: all 0.2s;
  border: 1px solid var(--mainOrange);
}
.main-btn:hover {
    background-color: var(--mainOrange);
    color: #fff;
}
.main-btn:active {
    transform: translateY(4px);
    box-shadow: 0 4px 0 var(--mainOrange);
}
button {
  margin: 15px;
}

</style>
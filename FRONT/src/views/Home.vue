<template>
  <body>
    <!-- <div class="background">
      <p>가보자고</p>
    </div> -->
    <!-- <img class="bg" src="../../../static/img_used/main.png" alt=""> -->
    <div class="setting-btn">
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('Create')">여행 만들기</button>
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('SelectPage')">여행 찾기</button>
      <button class="main-btn" type="button" v-if="!this.$store.state.isLogin" @click="showModal">회원가입</button>
    </div>
    <LoginModal 
    :show="modalShow" 
    @close="hiddenModal"
    v-on:update="onLogin" />
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
    if(this.$store.state.user.iuser){
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
    /* transition: 3s; */
  }
  /* .background {
    background-image: url('../../../static/img_used/main.png');
    background-size: cover;
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
  } */
  /* .bg {
    position: relative;
    top: 100px;
  } */
  .setting-btn {
    /* z-index: 9999; */
    text-align: center;
    position: absolute;
    bottom: 300px;
    left: 800px;
  }
  .main-btn { 
    font-family: 'LeferiPoint-WhiteA';
    display: inline-block;
    text-decoration: none;
    background: #fff;
    padding: 8px 30px;
    border-radius: 7px;
    /* font-family: helvetica; */
    font-weight: bold;
    color: #2d7ac2;
    box-shadow: 0 8px 0 #b1b1b1;
    transition: all 0.2s;
}

.main-btn:active {
    transform: translateY(4px);
    box-shadow: 0 4px 0 #2d7ac2;
}
  button {
    margin: 15px;
  }

</style>
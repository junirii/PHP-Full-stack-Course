<template>
  <body>
    <!-- <div class="background">
      <p>가보자고</p>
    </div> -->
    <img class="bg" src="../../../static/img_used/main.png" alt="">
    <div class="setting-btn">
      <button class="btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('Create')">HOSTING</button>
      <button class="btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('SelectPage')">SEARCH</button>
      <button class="btn" type="button" v-if="!this.$store.state.isLogin" @click="showModal">JOIN</button>
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
    height: 100%;
  }
  .background {
    background-image: url('../../../static/img_used/main.png');
    background-size: cover;
    /* background-clip: text;
    -webkit-background-clip: text;
    color: transparent; */
  }
  /* .background p {
    font-size: 300px;
    font-weight: bolder;
    text-align: center;
  } */
  .bg {
    width: 1903px;
    height: 1000px;
    position: relative;
    background-size: contain;
  }
  .setting-btn {
    position: relative;
    bottom: 400px;
  }
  button {
    margin: 15px;
  }

</style>
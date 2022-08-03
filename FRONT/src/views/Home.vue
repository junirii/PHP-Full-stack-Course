<template>
  <div class="setting-btn">
    <button class="btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('Create')">HOSTING</button>
    <button class="btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('SelectPage')">SEARCH</button>
    <button class="btn" type="button" v-if="!this.$store.state.isLogin" @click="showModal">JOIN</button>
  </div>
  <LoginModal 
  :show="modalShow" 
  @close="hiddenModal"
  v-on:update="onLogin" />
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

<style>
  .setting-btn {
    padding: 150px;
  }
</style>
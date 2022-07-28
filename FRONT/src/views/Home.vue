<template>
  <div class="setting-btn">
    <button class="btn" type="button" v-if="isLogin" @click="loginCheck('Create')">HOSTING</button>
    <button class="btn" type="button" v-if="isLogin" @click="loginCheck('Map')">SEARCH</button>
    <button class="btn" type="button" v-if="!isLogin" @click="showModal">JOIN</button>
    <div>
      <button class="btn" type="button" v-if="isLogin" @click="logout">로그아웃</button>
    </div>
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
      isLogin: false
    };
  },
  components: {
    LoginModal
  },
  created(){
    if(this.$store.state.user.iuser){
      this.isLogin = true;
    }
  },
  methods: {
    showModal(){
      this.modalShow = true;
    },
    hiddenModal(){
      this.modalShow = false;
    },
    onLogin(){
      this.isLogin = true;
    },
    loginCheck(path){
      if(this.isLogin === true){ //로그인 o 경우
        this.$router.push({path: `/${path}`}); //라우터 주소 이동
      }else{ //로그인 x 경우
        this.$swal.fire('로그인해주세요.', '', 'warning')
        .then(async result => {
          if(result.isConfirmed){
            this.modalShow = true;
          }
        });
        
      }
    },
    async logout(){
      if(this.isLogin === true){
        const res = await this.$post('/user/logout');
        if(res.result === 1){
          this.$store.commit('user', {});
          console.log(this.$store.state.user.iuser);
          this.isLogin = false;
          this.$swal.fire('로그아웃되었습니다.', '', 'success');
        }else{
          this.$swal.fire('로그아웃 실패', '', 'error');
        }
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
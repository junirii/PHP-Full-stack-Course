<template>
  <body>
    <div class="setting-btn">
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin"
              @click="loginCheck('Create')">여행 만들기</button>
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin"
              @click="loginCheck('SelectPage')">여행 찾기</button>
      <button class="main-btn" type="button" v-if="!this.$store.state.isLogin" @click="showModal">들어가기</button>
    </div>
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
}
* {
  margin: 0;
}

html {
  font-size: 16px;
  font-family: 'LeferiPoint-WhiteA';
}

.header {
  z-index: 1;
  width: 90%;
  position: fixed;
  top: 0;
  left: 80px;
  right: 0;

  padding: 1rem;
  color: white;
  font-weight: bold;
  align-items: center;

  border-bottom: 2px solid var(--mainOrange);
  height: 5rem;
}

.header-box {
  display: flex;
  justify-content: space-between;
}

/* .icons {
  display: flex;
  justify-content: space-between;
  width: 150px;
} */
.logo-box {
  display: flex;
  justify-content: space-between;
}

.logo {
  padding: 12px;
  color: var(--maincolor);
  font-weight: bolder;
}

.notifi {
  padding: 6px;
  display: flex;
  cursor: pointer;
  justify-content: center;
  align-items: center;
  position: relative;
  right: 65px;
  bottom: 41px;
}

.chat {
  padding: 6px;
  display: flex;
  cursor: pointer;
  justify-content: center;
  align-items: center;
  position: relative;
  right: 125px;
  top: 4px;
}

/*사이드 바*/
.burger-wrapper {
  cursor: pointer;
  padding: 6px;
}

#menu {
  background: var(--mainOrange);
  width: 15rem;
  height: 100vh;
  position: fixed;
  right: 0;
  transition-timing-function: cubic-bezier(10, 2, 3, 1);
  transform: translateX(50rem);
  top: 0;
  z-index: 10;
  transition: 0.5s;
  padding-top: 100px;
  border-left-color: var(--mainOrange);
}

li {
  color: #fff;
  font-size: 1.2rem;
  cursor: pointer;
  transition: 0.3s;
  min-width: 120px;
  list-style: none;
  padding: 8px;
  text-decoration-line: none;
}

#sideMenu {
  display: none;
}

#sideMenu:checked~#menu {
  transform: translateX(0rem);
}

#burger {
  position: absolute;
  cursor: pointer;
  width: 2rem;
  height: 2rem;
  right: 1rem;
  top: 1.5rem;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
}

#burger>div {
  height: 3px;
  background-color: var(--maincolor);
  transition: 0.5s;
  z-index: 999;
}

#sideMenu:checked~#burger>div {
  background-color: #fff;
}

#sideMenu:checked~#burger>div:nth-child(1) {
  transform: translateY(15px) rotate(45deg);
}

#sideMenu:checked~#burger>div:nth-child(2) {
  opacity: 0;
}

#sideMenu:checked~#burger>div:nth-child(3) {
  transform: translateY(-15px) rotate(-45deg);
}
.setting-btn {
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
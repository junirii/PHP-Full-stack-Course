<template>
  <!-- <div class="header-box">
      <div class="logo-box">
          <router-link :to="{ path: '/' }">
              <h2 class="logo">여행어쩌구</h2>
          </router-link>
          <div style="color: black;">{{ this.$store.state.user.nick }}님 ㅎㅇㅎㅇ</div>
      </div>
      <div class="icons">
          
          <div class="chat">
              <div>
                  <span id="unreadCntAll" style="color: red; font-weight: bold;"
                      class="d-none">{{ unreadCntAll }}</span>
                  <i class="fa-regular fa-message fa-2x" style="color: var(--maincolor);"
                      @click="showDivChat"></i>
                  <div v-if="divChatShow" style="margin-top: 100px;">
                      <div v-for="item in chatRooms" :key="item.itravel">
                          <div style="color: var(--mainOrange);" @click="goToChat(item.itravel)">
                              {{ item.title }}<br>{{ item.lastMsg }}
                              <span v-if="this.$store.state.unreadCnt[item.itravel]"
                                  style="color: red; font-weight: bold;">{{ this.$store.state.unreadCnt[item.itravel] }}</span>
                              <hr>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="notifi">
              <i class="fa-regular fa-bell fa-2x dropdown" style="color: var(--maincolor);" @click="selRequest();"
                  type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
              <ul class="dropdown-menu">
                  <div :key="item.iuser" v-for="item in selStateList">
                      <li v-if="item.isconfirm == 0" class="dropdown-item" style="cursor: default;">
                          <div>신청이 왔습니다.</div> {{ item.profile_img }} {{ item.nick }} 님께서 {{ item.title }}
                          <button @click="request(item.itravel, item.iuser)">수락</button> <button
                              @click="requestDel(item.itravel, item.iuser)">거절</button>
                      </li>
                      <li v-if="item.isconfirm == 3" class="dropdown-item" style="cursor: default;">
                          <div> {{ item.nick }}님 신청이 거절되었습니다.</div> {{ item.title }} <button
                              @click="requestNo(item.itravel, item.iuser)">확인</button>
                      </li>
                      <li v-if="item.isconfirm == 1" class="dropdown-item" style="cursor: default;">
                          <div> {{ item.nick }}님 신청이 수락되었습니다.</div> {{ item.title }} <button
                              @click="requestYes()">확인</button>
                      </li>
                  </div>
              </ul>
          </div>
      </div>
      <div class="burger-wrapper">
          <input type="checkbox" id="sideMenu">
          <label id="burger" for="sideMenu">
              <div></div>
              <div></div>
              <div></div>
          </label>
          <nav id="menu">
              <ul>
                  <li v-if="this.$store.state.isLogin" @click="goToMyPage">마이페이지</li>
                  <router-link :to="{ path: '/MyAccount' }">
                      <li v-if="this.$store.state.isLogin">회원정보 수정</li>
                  </router-link>
                  <li v-if="this.$store.state.isLogin">DM</li>
                  <router-link :to="{ path: '/Create' }">
                      <li v-if="this.$store.state.isLogin">여행 호스팅 하기</li>
                  </router-link>
                  <li v-if="this.$store.state.isLogin" @click="goToAllList">전체 리스트</li>
                  <li v-if="this.$store.state.isLogin" @click="logout">로그아웃</li>
                  <li v-if="!this.$store.state.isLogin" @click="logout">로그인</li>
              </ul>
              <div class="overlay"></div>
          </nav>
      </div>
  </div> -->

  <body>
    <!-- <div class="background">
      <p>가보자고</p>
    </div> -->
    <!-- <img class="bg" src="../../../static/img_used/main.png" alt=""> -->
    <div class="setting-btn">
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('Create')">여행 만들기</button>
      <button class="main-btn" type="button" v-if="this.$store.state.isLogin" @click="loginCheck('SelectPage')">여행 찾기</button>
      <button class="main-btn" type="button" v-if="!this.$store.state.isLogin" @click="showModal">들어가기</button>
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
      divChatShow: false,
      chatRooms: [],
      selStateList: [],
      refusalMsg: [],
      agreeMag: [],
      unreadCntAll: this.$store.state.unreadCntAll
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
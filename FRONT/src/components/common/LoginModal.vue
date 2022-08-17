<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper" style="z-index: 10;" @click="$emit('close')">
        <div class="modal-container font bolder" @click.stop="">
          <div class="modal-header">
            <p class="login-header">{{ header }}</p>
          </div>

          <!-- 로그인 폼 -->
          <form v-if="login" v-on:submit.prevent="loginForm">
            <div class="modal-body">
              <!-- <slot name="body">{{body}}</slot> -->
              <div class="title-input"><input v-model="loginUser.email" type="email" placeholder="이메일"></div>
              <div class="title-input"><input v-model="loginUser.pw" type="password" placeholder="비밀번호"></div>
              <div>
                <p class="btn-join" type="button" @click="showJoin">아직 회원이 아니신가요?</p>
                <div class="btn-logo"><img class="loginButton" src="../../../static/img_used/kakaologin.png"
                    alt="kakaologin" type="button" @click="kakaoLogin"></div>
                <!-- 구글 로그인-->
                <div class="test btn-logo">
                  <div class="google-div" v-on:click="GoogleLoginBtn"><img
                      src="../../../static/img_used/logingoogle.png" alt="구글 소셜로그인"></div>
                  <div class="google-div" id="my-signin2" style="display: none"></div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <div v-if="login" class="modal-login-button">
                <slot name="footer">
                  <button class="btn-css" type="submit">로그인</button>
                  <button class="btn-css" type="button" @click="$emit('close'); showLogin();">취소</button>
                </slot>
              </div>
            </div>
          </form>


          <!-- 회원가입 폼 -->
          <form v-if="join" v-on:submit.prevent="joinForm">
            <div class="modal-body2">
              <div class="modal-body2-left">
                <div class="title-input"><input v-model="joinUser.email" type="email" placeholder="아이디" required></div>
                <div class="title-input"><input v-model="joinUser.pw" type="password" placeholder="비밀번호" required></div>
                <div class="title-input">
                  <input v-model="joinUser.pwCheck" type="password" placeholder="비밀번호 확인" required>
                  <div v-if="joinUser.pwCheck !== ''">
                    <div v-show="joinUser.pw === joinUser.pwCheck">비밀번호가 일치합니다.</div>
                    <div v-show="joinUser.pw !== joinUser.pwCheck">비밀번호가 일치하지 않습니다.</div>
                  </div>
                </div>
                <div class="title-input"><input v-model="joinUser.nm" type="text" placeholder="이름" required></div>
                <div class="title-input"><input v-model="joinUser.nick" type="text" placeholder="닉네임"></div>
                <div>성별 :
                  <input v-model="joinUser.gender" type="radio" id="male" name="gender" value="1" checked required>
                  <label for="male">남</label>
                  <input v-model="joinUser.gender" type="radio" id="female" name="gender" value="2">
                  <label for="female">여</label>
                </div>
                <div class="title-input">
                  <label>생일 : <input v-model="joinUser.birth" type="date" required></label>
                </div>
                <div class="title-input"><input v-model="joinUser.tel" type="tel" placeholder="전화번호('-'빼고 입력)" required></div>
                <div class="title-input d-none"><label>프로필 이미지<input type="file"
                      @change="toBase64($event.target.files)"></label></div>
                <div class="title-input"><input v-model="joinUser.cmt" type="text" placeholder="소개말"></div>
              </div>
              <div class="p-go-login">
                <p>이미 회원이신가요?</p>
                <p type="button" @click="showLogin">로그인 하기</p>
              </div>
            </div>

            <div class="modal-footer">
              <div v-if="join" class="modal-login-button">
                <slot name="footer">
                  <button class="btn-css" type="button" @click="joinForm"
                    v-bind:disabled="joinUser.pw !== joinUser.pwCheck || joinUser.pwCheck === ''">회원가입</button>
                  <button class="btn-css" type="button" @click="$emit('close'); showLogin();">취소</button>
                </slot>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script>

// import { request } from 'http';

export default {
  name: "LoginModal",
  name: "test",

  props: {
    show: Boolean,
  },
  data() {
    return {
      login: true,
      join: false,
      header: '로그인',
      isLogin: this.isLogin,
      joinUser: {
        social_type: 0,
        email: '',
        pw: '',
        pwCheck: '',
        nm: '',
        nick: '',
        gender: 0,
        birth: '',
        tel: '',
        profile_img: '',
        cmt: ''
      },
      loginUser: {
        email: '',
        pw: ''
      },
    }
  },
  methods: {
    kakaoLogin() {
      console.log(window.Kakao)
      window.Kakao.Auth.login({
        scope: 'profile_nickname, profile_image, account_email, gender',
        success: this.getKakaoAccount,
        fail: e => {
          console.error(e);
        }
      });
    },
    getKakaoAccount(authObj) {
      console.log(authObj);
      window.Kakao.API.request({
        url: '/v2/user/me',
        success: async res => {
          const acc = res.kakao_account;
          console.log(acc);
          const params = {
            social_type: 1,
            nm: acc.profile.nickname,
            nick: acc.profile.nickname,
            email: acc.email,
            profile_img: acc.profile.profile_image_url,
            gender: acc.gender
          }
          if (acc.gender === 'male') {
            params.gender = 1
          } else {
            params.gender = 2
          }
          console.log(params);
          const data = await this.$post('/user/join', params);
          console.log(data);
          if (data.result === 2) {
            const res = await this.$get(`/user/getKakaoIuser/${acc.email}`, {});
            this.$store.state.isLogin = true;
            console.log(res);
            params.iuser = res.result.iuser;
            this.$store.commit('user', params);
            console.log(this.$store.state.user);
            this.$emit('close');
            this.$emit('update');
          }
        },
        fail: e => {
          console.error(e);
        }
      })
    },
    // async login(params) {
    //       const data = await this.$post('/user/login', params);
    //       params.iuser = data.result;
    //       this.$store.commit('user', params);
    //       window.location.href = "http://location:8080/";
    // },
    async toBase64(files) {
      const profileImg = await this.$base64(files[0]);
      this.joinUser.profile_img = profileImg;
    },
    showJoin() {
      this.login = false;
      this.join = true;
      this.header = '회원가입';
      this.joinUser.email = '';
      this.joinUser.pw = '';
      this.joinUser.pwCheck = '';
      this.joinUser.nm = '';
      this.joinUser.nick = '';
      this.joinUser.birth = '';
      this.joinUser.tel = '';
      this.joinUser.cmt = '';
    },
    showLogin() {
      this.login = true;
      this.join = false;
      this.header = '로그인';
      this.loginUser.email = '';
      this.loginUser.pw = '';
    },
    async joinForm() {
      console.log('회원가입 시도');
      const res = await this.$post('/user/join', this.joinUser);
      console.log(res);
      if (res.result === 2) { //아이디 중복
        this.$swal.fire('중복되는 아이디가 있습니다.', '', 'error');
      } else if (res.result === 1) { //회원가입 성공
        this.$swal.fire('회원가입 되었습니다!', '', 'success');
        this.showLogin();
      } else { //회원가입 실패
        this.$swal.fire('회원가입할 수 없습니다.', '', 'error');
      }
      this.$emit('close');
      this.$emit('update');
    },
    async loginForm() {
      // const options = { //$enc_data 를 php 의 main 에서 가져오기 위한 옵션
      //   url: '/user/login',
      //   method: 'POST',
      //   form: {
      //     email: this.loginUser.email,
      //     pw: this.loginUser.pw
      //   },
      //   json: true
      // };
      // request.post(options, function(err, httpResponse, body){
      //   console.log(httpResponse);
      // });

      const res = await this.$post('/user/login', {
        email: this.loginUser.email,
        pw: this.loginUser.pw
      });
      if (res.result === 0) {
        this.$swal.fire('일치하는 회원이 없습니다.', '', 'error'); //로그인 실패
      } else {
        this.$store.commit('user', res.result); //로그인 성공
        this.$store.state.isLogin = true;
        console.log(this.$store.state.user);
        console.log(this.$store.state.isLogin);
        this.$emit('close');
        this.$emit('update');
      }
    },

    /* 구글 로그인 */
    GoogleLoginBtn: function () {
      var self = this;

      window.gapi.signin2.render('my-signin2', {
        scope: 'profile email',
        width: 240,
        height: 50,
        longtitle: true,
        theme: 'dark',
        onsuccess: this.GoogleLoginSuccess,
        onfailure: this.GoogleLoginFailure,
      });

      setTimeout(function () {
        if (!self.googleLoginCheck) {
          const auth = window.gapi.auth2.getAuthInstance();
          auth.isSignedIn.get();
          document.querySelector('.abcRioButton').click();
        }
      }, 1500)

    },
    async GoogleLoginSuccess(googleUser) {
      const googleEmail = googleUser.getBasicProfile().getEmail();
      if (googleEmail !== 'undefined') {
        console.log(googleEmail);
      }
    },
    //구글 로그인 콜백함수 (실패)
    GoogleLoginFailure(error) {
      console.log(error);
    },
  }
}
</script>

<style scoped>
.loginButton {
  width: 220px;
}

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}

.modal-body {
  margin: 20px 0;
  color: var(--maincolor);
}

.modal-footer {
  text-align: center;
}

.modal-login-button {
  /* display: inline-block; */
  border: 0;
  background: none;
  font-weight: bolder;
  color: var(--mainOrange);
  font-size: 20px;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */
.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.swal2-container {
  z-index: 20000 !important;
}

/* 모달 끝 */
.test {
  display: flex;
  justify-content: center;
  align-items: center;
  /* height: 100vh; */
}

.modal-body2 {
  color: var(--maincolor);
}

.google-div img {
  width: 220px;
  cursor: pointer;
  /* height: 40px;
  background-color: #ffffff;
  border: 1px #a8a8a8 solid;
  color: black;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer; */
}

.login-header {
  color: var(--maincolor);
}

.title-input{
  padding: 5px;
}
/* .title-input:hover {
    border-bottom: 2px solid var(--mainDark);
} */
.title-input:focus {
  outline: none;
}

.title-input>select,
.title-input>input {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;

  border: none;
  border-bottom: 2px solid var(--maincolor);
  width: 200px;
  height: 25px;
  padding-left: 10px;
  color: var(--maincolor);
}

.btn-join {
  padding-top: 20px;
  color: var(--maincolor);
  margin: 0 auto;
}

.btn-logo {
  margin: 0
}

.btn-css {
  font-family: 'LeferiPoint-WhiteA';
  display: inline-block;
  text-decoration: none;
  background: #fff;
  padding: 4px 8px;
  border-radius: 7px;
  font-weight: bold;
  color: var(--mainOrange);
  box-shadow: 0 8px 0 var(--mainDarkOrange);
  transition: all 0.2s;
  border: 1px solid var(--mainOrange);
}

.btn-css:hover {
  background-color: var(--mainOrange);
  color: #fff;
}

.btn-css:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 var(--mainOrange);
}

button {
  margin: 15px;
}

input:focus {
  outline: none;
}

.p-go-login {
  margin-top: 30px;
}
</style>
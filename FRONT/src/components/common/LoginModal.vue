<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper" style="z-index: 10;" @click="$emit('close')">
        <div class="modal-container" @click.stop="">
          <div class="modal-header">
            <p>{{header}}</p>
          </div>

          <!-- 로그인 폼 -->
          <form v-if="login" v-on:submit.prevent="loginForm">
            <div class="modal-body">
            <!-- <slot name="body">{{body}}</slot> -->
              <div><input v-model="loginUser.email" type="email" placeholder="아이디"></div>
              <div><input v-model="loginUser.pw" type="password" placeholder="비밀번호"></div>
              <div>
                <p>아직 회원이 아니신가요?</p>
                <p type="button" @click="showJoin">Sign Up</p>
              </div>
            </div>

            <div class="modal-footer">
              <div v-if="login" class="modal-login-button">
                <slot name="footer">
                  <button type="submit">로그인</button>
                  <button type="button" @click="$emit('close')">취소</button>
                </slot>
              </div>
            </div>
          </form>

          <!-- 회원가입 폼 -->
          <form v-if="join" v-on:submit.prevent="joinForm">
            <div class="modal-body">
              <div><input v-model="joinUser.email" type="email" placeholder="아이디" required></div>
              <div><input v-model="joinUser.pw" type="password" placeholder="비밀번호" required></div>
              <div>
                <input v-model="joinUser.pwCheck" type="password" placeholder="비밀번호 확인" required>
                <div v-show="joinUser.pw===joinUser.pwCheck">비밀번호가 일치합니다.</div>
                <div v-show="joinUser.pw!==joinUser.pwCheck">비밀번호가 일치하지 않습니다.</div>
              </div>
              <div><input v-model="joinUser.nm" type="text" placeholder="이름" required></div>
              <div><input v-model="joinUser.nick" type="text" placeholder="닉네임"></div>
              <div>
                <input v-model="joinUser.gender" type="radio" id="male" name="gender" value="0" checked required>
                <label for="male">남</label>
                <input v-model="joinUser.gender" type="radio" id="female" name="gender" value="1">
                <label for="female">여</label>
              </div>
              <div>
                <label>생일<input v-model="joinUser.birth" type="date" required></label>
              </div>
              <div><input v-model="joinUser.tel" type="tel" placeholder="전화번호" required></div>
              <div><label>프로필 이미지<input type="file"></label></div>
              <div><input v-model="joinUser.cmt" type="text" placeholder="소개말"></div>
              <div>
                <p>이미 회원이신가요?</p>
                <p type="button" @click="showLogin">Sign In</p>
              </div>
            </div>

            <div class="modal-footer">
              <div v-if="join" class="modal-login-button">
                <slot name="footer">
                  <button type="submit" v-bind:disabled="joinUser.pw!=joinUser.pwCheck">회원가입</button>
                  <button type="button" @click="$emit('close'); showLogin();">취소</button>
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
  props: {
    show: Boolean,
  },
  data(){
    return {
      login: true,
      join: false,
      header: '로그인',
      isLogin: this.isLogin,
      joinUser: {
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
      }
    }
  },
  methods: {
    showJoin(){
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
    showLogin(){
      this.login = true;
      this.join = false;
      this.header = '로그인';
      this.loginUser.email = '';
      this.loginUser.pw = '';
    },
    async joinForm(){
      const res = await this.$post('/user/join', this.joinUser);
      if(res.result === 2){ //아이디 중복
        this.$swal.fire('중복되는 아이디가 있습니다.', '', 'error');
      }else if(res.result === 1){ //회원가입 성공
        this.$swal.fire('회원가입 되었습니다!', '', 'success');
        this.showLogin();
      }else{ //회원가입 실패
        this.$swal.fire('회원가입할 수 없습니다.', '', 'error');
      }
    },
    async loginForm(){
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
      if(res.result === 0){
        this.$swal.fire('일치하는 회원이 없습니다.', '', 'error'); //로그인 실패
      }else{
        this.$store.commit('user', res.result); //로그인 성공
        this.$emit('close');
        this.$emit('update');
      }
    },
  }
}
</script>

<style>
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
.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}
.modal-body {
  margin: 20px 0;
}
.modal-footer {
  text-align: center;
  }

.modal-login-button {
  display: inline-block;
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
</style>
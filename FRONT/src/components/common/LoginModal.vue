<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper" style="z-index: 10;" @click="$emit('close')">
        <div class="modal-container" @click.stop="">
          <div class="modal-header">
            <p>{{header}}</p>
          </div>

          <!-- 로그인 폼 -->
          <form v-if="login" @submit.prevent="loginForm">
            <div class="modal-body">
            <!-- <slot name="body">{{body}}</slot> -->
              <div><input type="email" placeholder="아이디"></div>
              <div><input type="password" placeholder="비밀번호"></div>
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
              <div><input v-model="user.email" type="email" placeholder="아이디" required></div>
              <div><input v-model="user.pw" type="password" placeholder="비밀번호" required></div>
              <div>
                <input v-model="user.pwCheck" type="password" placeholder="비밀번호 확인" required>
                <div v-show="user.pw===user.pwCheck">비밀번호가 일치합니다.</div>
                <div v-show="user.pw!==user.pwCheck">비밀번호가 일치하지 않습니다.</div>
              </div>
              <div><input v-model="user.nm" type="text" placeholder="이름" required></div>
              <div><input v-model="user.nick" type="text" placeholder="닉네임"></div>
              <div>
                <input v-model="user.gender" type="radio" id="male" name="gender" value="0" checked required>
                <label for="male">남</label>
                <input v-model="user.gender" type="radio" id="female" name="gender" value="1">
                <label for="female">여</label>
              </div>
              <div>
                <label>생일<input v-model="user.birth" type="date" required></label>
              </div>
              <div><input v-model="user.tel" type="tel" placeholder="전화번호" required></div>
              <div><label>프로필 이미지<input type="file"></label></div>
              <div><input v-model="user.cmt" type="text" placeholder="소개말"></div>
              <div>
                <p>이미 회원이신가요?</p>
                <p type="button" @click="showLogin">Sign In</p>
              </div>
            </div>

            <div class="modal-footer">
              <div v-if="join" class="modal-login-button">
                <slot name="footer">
                  <button type="submit" v-bind:disabled="user.pw!==user.pwCheck" @click="$emit('close'); showLogin();">회원가입</button>
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
export default {
  name: "LoginModal",
  props: {
    show: Boolean,
    body: String
  },
  data(){
    return {
      login: true,
      join: false,
      header: '로그인',
      user: {
        email: 'ga243@naver.com',
        pw: '123',
        pwCheck: '',
        nm: '123',
        nick: 'www',
        gender: 0,
        birth: '1997-01-24',
        age: 0,
        tel: '010-2825-2536',
        profile_img: '',
        cmt: 'zzz'
      }
    }
  },
  methods: {
    showJoin(){
      this.login = false;
      this.join = true;
      this.header = '회원가입';
    },
    showLogin(){
      this.login = true;
      this.join = false;
      this.header = '로그인';
    },
    async joinForm(){
      const birth = this.user.birth;
      const birthYear = birth.substr(0, 4);
      const thisYear = new Date().getFullYear();
      this.user.age = thisYear - birthYear;
      const res = await this.$post('/user/join', this.user);
      if(res.result === 1){
        this.$swal.fire('회원가입 되었습니다!', '', 'success');
      }else if(res.result === 2){
        this.$swal.fire('중복되는 아이디가 있습니다.', '', 'error');
      }else{
        this.$swal.fire('로그인할 수 없습니다.', '', 'error');
      }
    },
    async loginForm(){
      const res = await this.$post('/user/login', this.user);
      console.log(res);
    }
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
</style>
<template>
  <div class="location">
    <div class="container">

      <h1>회원정보 수정</h1>
      <div class="myaccount-profile">
        <div class="item">이메일 : <input type="email" v-model="loginUser.email"></div>
        <div class="item">비밀번호 : <input type='button' v-if="!pwShow" value='비밀번호 변경' @click="showPw">
          <span>
            <input type='password' v-if="pwShow" v-model="pw" placeholder="새 비밀번호">
          </span>
          <span>
            <input type='password' v-if="pwShow" v-model="pwCheck" placeholder="새 비밀번호 확인">
          </span>
          <input type='button' v-if="pwShow" value='취소' @click="cancel">
          <div v-if="pwShow">
            <div v-show="pw!=='' && pw===pwCheck">비밀번호가 일치합니다.</div>
            <div v-show="pw!==pwCheck">비밀번호가 일치하지 않습니다.</div>
          </div>
        </div>
        <div class="item">이름 : <input type="text" v-model="loginUser.nm"></div>
        <div class="item">닉네임 : <input type="text" v-model="loginUser.nick"></div>
        <div class="item">성별 :
          <input v-model="loginUser.gender" type="radio" id="male" name="gender" value="1"
            checked="this.loginUser.gender == 1 ? ='checked' : =''">
          <label for="male">남성</label>
          <input v-model="loginUser.gender" type="radio" id="female" name="gender" value="2">
          <label for="female">여성</label>
        </div>
        <div class="item">생년월일 : <input type="date" v-model="loginUser.birth"></div>
        <div class="item">전화번호 : <input type="tel" v-model="loginUser.tel"></div>
        <div class="item">상태메세지 : <input type="text" v-model="loginUser.cmt"></div>
      </div>


      <div>
        <button type="button" @click="myAccountMod" 
        v-bind:disabled="pwShow && (pw !== pwCheck || pwCheck === '')">수정</button>
        <!-- <router-link :to="{ path: '/MyAccount' }"><button>취소</button></router-link> -->
        <button type="button" @click="goToMyAccount">취소</button>
        <button type="button">회원탈퇴</button>
      </div>

      <br>
    </div>
  </div>

</template>

<script>

export default {
  data() {
    return {
      data: [],
      loginUser: {},
      pw: '',
      pwCheck: '',
      pwShow: false
    }
  },
  methods: {
    async getMyAccount() { // iuser
      // console.log(this.$store.state.user);
      this.loginUser = JSON.parse(JSON.stringify(this.$store.state.user));
      console.log(this.loginUser);
    },
    async myAccountMod() {
      // 회원정보 수정 (마이페이지 댓글 참고)
      if(this.pw && this.pwCheck){
        this.loginUser.pw = this.pw;
        this.loginUser.pwCheck = this.pwCheck;
      };
        const res = await this.$post('/user/myAccountMod', this.loginUser);
        console.log(res);
        if (res.result === 1) {
          this.$store.state.user = this.loginUser;
          this.$router.push({ name: 'myaccount' });
        }
      },
    showPw() {
      this.pwShow = true;
    },

    // 비밀번호 취소버튼
    cancel() {
      this.pwShow = false;
      this.pw = '';
      this.pwCheck = '';
    },

    // 전체페이지 취소버튼 (myaccount페이지로 가도록, DB입력은 되지않으나, front에서 띄워짐ㅠㅠ)
    goToMyAccount() {
      this.$router.push({ name: 'myaccount' });

    }
    // 비밀번호 변경버튼
  },
  created() {
    this.getMyAccount();
  }
}
</script>

<style scoped>
.location {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}

.container {
  color: var(--maincolor);
  width: 100vh;
}

.myaccount-profile {
  display: flex;
  flex-direction: column;
  border: 1px solid var(--maincolor);
}

.item {
  background-color: #fff;
  color: var(--maincolor);
  text-align: start;
  height: 5vh;
  margin: 5px;
  padding: 5px;
}

input {
  border: none;
  border-bottom: 1px solid var(--maincolor);
  padding: 5px;
}

</style>
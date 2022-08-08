<template>
  <div class="location">
    <div class="container">
      <h1>회원정보 수정</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진<input type="file"></div>
        <div class="myaccount_profile_txt">
          <div>이메일 : <input type="email" v-model="loginUser.email"></div>
          <div>비밀번호 : <input type="email" v-model="loginUser.pw"></div>
          <div>이름 : <input type="text" v-model="loginUser.nm"></div>
          <div>닉네임 : <input type="text" v-model="loginUser.nick"></div>
          <div>성별 :
            <input v-model="loginUser.gender" type="radio" id="male" name="gender" value="1">
            <label for="male">남성</label>
            <input v-model="loginUser.gender" type="radio" id="female" name="gender" value="2">
            <label for="female">여성</label>
          </div>
          <div>생년월일 : <input type="date" v-model="loginUser.birth"></div>
          <div>전화번호 : <input type="tel" v-model="loginUser.tel"></div>
          <div>상태메세지 : <input type="text" v-model="loginUser.cmt"></div>
        </div>
      </div>

      <div>
          <button type="button" @click="myAccountMod">수정</button>
        <router-link :to="{ path: '/Myaccount' }">
          <button type="reset">취소</button>
        </router-link>
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


    }
  },
  methods: {
    async getMyAccount() { // iuser
      // console.log(this.$store.state.user);
      this.loginUser = this.$store.state.user;
    },
    async myAccountMod() {
      /*마이페이지 댓글 참고.....*/
      const res = await this.$post('/user/myAccountMod', {
        profile_img: this.loginUser.profile_img,
        email: this.loginUser.email,
        pw: this.loginUser.pw,
        nm: this.loginUser.nm,
        nick: this.loginUser.nick,
        gender: this.loginUser.gender,
        birth: this.loginUser.birth,
        tel: this.loginUser.tel,
        cmt: this.loginUser.cmt,
        iuser: this.loginUser.iuser
      });
      console.log(res);
      if (res.result === 1) {
        this.$store.state.user = this.loginUser;
        this.$router.push({name: 'myaccount'});
      }
    }

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

.myaccount_profile {
  border: 1px solid grey;
  border-radius: 5px;
}
</style>
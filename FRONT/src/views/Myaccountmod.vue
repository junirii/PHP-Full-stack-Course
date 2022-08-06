<template>
  <div class="location">
    <div class="container">
      <h1>Myaccount Mod</h1>

      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진<input type="file"></div>
        <div class="myaccount_profile_txt">
          <div>이메일 : <input type="email" v-model="loginUser.email"></div>
          <div>비밀번호 : </div>
          <div>이름 : <input type="text" v-model="loginUser.nm"></div>
          <div>닉네임 : <input type="text" v-model="loginUser.nick"></div>
          <div>성별 :
            <input v-model="loginUser.gender" type="radio" id="male" name="gender" value="1">
            <label for="male">남</label>
            <input v-model="loginUser.gender" type="radio" id="female" name="gender" value="2">
            <label for="female">여</label>
          </div>
          <div>생년월일 : <input type="date" v-model="loginUser.birth"></div>
          <div>전화번호 : <input type="tel" v-model="loginUser.tel"></div>
          <div>상태메세지 : <input type="text" v-model="loginUser.cmt"></div>
          <div><i class="fa-regular fa-paper-plane fa"></i>DM</div>
          <div><i class="fa-solid fa-heart fa"></i>인기도</div>
        </div>
      </div>

      <div>
        <router-link :to="{ path: '/Myaccount' }">
          <button type="button" @click="myAccountMod">수정</button>
        </router-link>
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
      loginUser: 0,
      loginUser: {
        profile_img: '',
        email: '',
        nm: '',
        nick: '',
        gender: 0,
        birth: '',
        tel: '',
        cmt: ''
      },


    }
  },
  methods: {
    async getMyAccount() { // iuser
      // console.log(this.$store.state.user);
      this.loginUser = this.$store.state.user;
    },
    async myAccountMod() {
      this.loginIuser = this.$store.state.user;

      /*마이페이지 댓글 참고.....*/
      const res = await this.$post('/user/myAccountMod', {
        profile_img: this.loginUser.profile_img,
        email: this.loginUser.email,
        nm: this.loginUser.nm,
        nick: this.loginUser.nick,
        gender: this.loginUser.gender,
        birth: this.loginUser.birth,
        tel: this.loginUser.tel,
        cmt: this.loginUser.cmt
      });

      if (res.result === 1) {
        this.loginUser.profile_img = '';
        this.loginUser.email = '';
        this.loginUser.nm = '';
        this.loginUser.nick = '';
        this.loginUser.gender = 0;
        this.loginUser.birth = 0;
        this.loginUser.tel = 0;
        this.loginUser.cmt = '';
        this.getMyAccount();
      }
    }

  },
  created() {
    this.getMyAccount();
    this.myAccountMod();
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
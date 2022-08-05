<template>
  <div class="location">
    <div class="container">
      <h1>Myaccount</h1><i class="fa-light fa-pencil"></i><i class="fa-light fa-pencil"></i>
      <router-link :to="{ path: '/Myaccount_mod' }">
        <button type="button">편집</button>
      </router-link>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진{{ selUser.profile_img }}</div>
        <div class="myaccount_profile_txt">
          <div>이메일 : {{ selUser.email }} </div>
          <div>비밀번호 : <button>변경</button></div>
          <div>이름 : {{ selUser.nm }} </div>
          <div>닉네임 : {{ selUser.nick }} </div>
          <div>성별 : {{ selUser.gender }} </div>
          <div>생년월일 : {{ selUser.birth }} </div>
          <div>전화번호 : {{ selUser.tel }} </div>
          <div>상태메세지 : {{ selUser.cmt }} </div>
          <div><i class="fa-regular fa-paper-plane"></i>DM</div>
          <div><i class="fa-solid fa-heart"></i>인기도</div>
        </div>
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
      selUser: {},
      loginIuser: 0,
    }
  },
  methods: {
    async getMyAccount() { // iuser
      console.log(this.$store.state.user);
      this.loginIuser = this.$store.state.user.iuser;
      console.log('loginIuser : ' + this.loginIuser);

      this.data = await this.$get(`/user/myAccount/${this.loginIuser}`, {}); // controllers / method
      console.log(this.data);
      this.selUser = this.data.result.selUser;
    },
  },
  created() {
    this.getMyAccount();
  }
}
</script>

<style scoped>
i {
  font-size: 40px;
  color: #000;
}

.myaccount_profile {
  border: 1px solid grey;
  border-radius: 5px;
}

.location {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}

.container {
  display: center;
  justify-content: center;
  flex-direction: center;
  text-align: center;
}
</style>
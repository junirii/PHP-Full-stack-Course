<template>
  <div class="location">
    <div class="container">
            <h1>Myaccount</h1>

      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진{{ selUser.profile_img }}</div><i class="fa-light fa-pencil"></i>
        <div class="myaccount_profile_txt">
          <div>이메일 : {{ selUser.email }}</div><i class="fa-light fa-pencil"></i>
          <div>비밀번호 : </div><i class="fa-light fa-pencil"></i>
          <div>이름 : {{ selUser.nm }}</div><i class="fa-light fa-pencil"></i>
          <div>닉네임 : {{ selUser.nick }}</div><i class="fa-light fa-pencil"></i>
          <div>성별 : {{ selUser.gender }}</div><i class="fa-light fa-pencil"></i>
          <div>생년월일 : {{ selUser.birth }}</div><i class="fa-light fa-pencil"></i>
          <div>전화번호 : {{ selUser.tel }}</div><i class="fa-light fa-pencil"></i>
          <div>상태메세지 : {{ selUser.cmt }}</div><i class="fa-light fa-pencil"></i>
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
.myaccount_profile {
  border: 1px solid grey;
  border-radius: 5px;
  width: 65vw;
}

.location {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
</style>
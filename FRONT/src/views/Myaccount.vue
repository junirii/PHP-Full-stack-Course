<template>
  <h1>Myaccount</h1>
  <br>
  <h1>Myaccount</h1>
  <br>
  <h1>Myaccount</h1>
  <br>
  <h1>Myaccount</h1>
  <br>
  <h1>Myaccount</h1>
  <br>

  <div class="container">
    <div class="myaccount_profile">
      <div class="myaccount_profile_img">사진{{ selUser.profile_img }}</div>
      <div class="myaccount_profile_txt">
        <div>이메일 : {{ selUser.email }}</div>
        <div>비밀번호 : </div>
        <div>이름 : {{ selUser.nm }}</div>
        <div>닉네임 : {{ selUser.nick }}</div>
        <div>성별 : {{ selUser.gender }}</div>
        <div>생년월일 : {{ selUser.birth }}</div>
        <div>전화번호 : {{ selUser.tel }}</div>
        <div>상태메세지 : {{ selUser.cmt }}</div>
        <div><i class="fa-regular fa-paper-plane"></i>DM</div>
        <div><i class="fa-solid fa-heart"></i>인기도</div>
      </div>
    </div>
    <br>
  </div>


</template>

<script>
export default {
  data() {
    return {
      selUser: {}
    }
  },
  methods: {
    async selUser() {
            console.log(this.$store.state.user);

      this.loginIuser = this.$store.state.user.iuser;
      this.data = await this.$get(`/user/myAccount/${this.loginIuser}`, {});
    }

  },
  created() {
    this.seUser();
  }
}
</script>

<style scoped>
</style>
<template>
  <div class="location">
    <div class="container">
      <h1>회원정보 수정</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진<input v-model="loginUser.profile_img"></div>
        <div class="myaccount_profile_txt">
          <div>이메일 : <input v-model="loginUser.email">
          </div>
          <div>비밀번호 : </div>
          <div>이름 : <input v-model="loginUser.nm"></div>
          <div>닉네임 : <input v-model="loginUser.nick"></div>
          <div>성별 : <input v-model="loginUser.gender"></div>
          <div>생년월일 : <input v-model="loginUser.birth"></div>
          <div>전화번호 : <input v-model="loginUser.tel"></div>
          <div>상태메세지 : <input v-model="loginUser.cmt"></div>
        </div>
        <button class="mod_submit" @click="">수정</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      loginUser: 0,
    }
  },
  methods: {
    async getMyAccount() { // iuser
      console.log(this.$store.state.user);
      this.loginUser = this.$store.state.user;
    },
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
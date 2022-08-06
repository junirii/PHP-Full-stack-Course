<template>
  <div class="location">
    <div class="container">
      <h1>내 계정</h1><i class="fa-light fa-pencil"></i><i class="fa-light fa-pencil"></i>
      <router-link :to="{ path: '/MyAccountMod' }">
        <button type="button">회원정보 수정</button>
      </router-link>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진{{ loginUser.profile_img }}</div>
        <div class="myaccount_profile_txt">
          <div>이메일 : {{ loginUser.email }} </div>
          <div>비밀번호 : <button>변경</button><button>확인</button></div>
          <div>이름 : {{ loginUser.nm }} </div>
          <div>닉네임 : {{ loginUser.nick }} </div>
          <div>성별 : {{ loginUser.gender }} </div>
          <div>생년월일 : {{ loginUser.birth }} </div>
          <div>전화번호 : {{ loginUser.tel }} </div>
          <div>상태메세지 : {{ loginUser.cmt }} </div>
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
<template>
  <div class="location">
    <div class="container">
      <h1>회원정보</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_txt">
          <div class="item">이메일 : {{ loginUser.email }} </div>
          <div class="item">비밀번호 : </div>
          <div class="item">이름 : {{ loginUser.nm }} </div>
          <div class="item">닉네임 : {{ loginUser.nick }} </div>
          <div class="item">성별 : {{ genderTxt }} </div>
          <div class="item">생년월일 : {{ loginUser.birth }} </div>
          <div class="item">전화번호 : {{ loginUser.tel }} </div>
          <div class="item">상태메세지 : {{ loginUser.cmt }} </div>
          <div><i class="fa-regular fa-paper-plane fa"></i>DM</div>
          <div><i class="fa-solid fa-heart fa"></i>인기도</div>
        </div>
      </div>

      <div>
        <router-link :to="{ path: '/myaccountmod' }">
          <i class="fa-solid fa-pencil fa"></i><button type="button">회원정보 수정</button>
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
      genderTxt: ''
    }
  },
  methods: {
    async getMyAccount() { // iuser
      // console.log(this.$store.state.user);
      this.loginUser = this.$store.state.user;
      if(this.loginUser.gender == 1) {
        this.genderTxt = '남성';
      } else {
        this.genderTxt = '여성';
      }
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
.container {
color: var(--maincolor);
}

.item{
  background-color: var(--maincolor);
  color: #fff;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  height: 5vh;
  margin: 15px;
  padding: 15px;
}

</style>
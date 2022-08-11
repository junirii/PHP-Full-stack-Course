<template>
  <div class="location">
    <div class="container">
      <h1>회원정보</h1>
      <div class="myaccount-profile">
          <div class="item"><div class="item-txt">이메일 : {{ loginUser.email }} </div></div>
          <div class="item"><div class="item-txt">이름 : {{ loginUser.nm }} </div></div>
          <div class="item"><div class="item-txt">닉네임 : {{ loginUser.nick }} </div></div>
          <div class="item"><div class="item-txt">성별 : {{ genderTxt }} </div></div>
          <div class="item"><div class="item-txt">생년월일 : {{ loginUser.birth }} </div></div>
          <div class="item"><div class="item-txt">전화번호 : {{ loginUser.tel }} </div></div>
          <div class="item"><div class="item-txt">상태메세지 : {{ loginUser.cmt }} </div></div>
          <div><i class="fa-regular fa-paper-plane fa"></i>DM</div>
          <div><i class="fa-solid fa-heart fa"></i>인기도</div>
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
.container{
  color: var(--maincolor);
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.item{
  background-color: var(--maincolor);
  color: #fff;
  margin: 10px;
  padding: 10px;
  height: 5vh;
  display: flex;
  align-items: center;
  width: 50vh;
}

</style>
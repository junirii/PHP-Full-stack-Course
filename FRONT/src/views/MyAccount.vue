<template>
  <div class="location">
    <div class="container">
      <h1>회원정보</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진
          <!-- <img :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" style="width: 20rem; height: 16rem;" alt="이미지"> -->
        </div>
        <div class="myaccount_profile_txt">
          <div>이메일 : {{ loginUser.email }} </div>
          <div>비밀번호 : </div>
          <div>이름 : {{ loginUser.nm }} </div>
          <div>닉네임 : {{ loginUser.nick }} </div>
          <div>성별 : {{ genderTxt }} </div>
          <div>생년월일 : {{ loginUser.birth }} </div>
          <div>전화번호 : {{ loginUser.tel }} </div>
          <div>상태메세지 : {{ loginUser.cmt }} </div>
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

.myaccount_profile {
  border: 1px solid grey;
  border-radius: 5px;
}
</style>
<template>
  <div class="my-account">
    <div class="container">
      <h1>회원정보</h1>
      <div class="myaccount-profile">  
        <div class="row">
          <div class="item-nm">이메일</div>
          <div class="item-nm">이름</div>
          <div class="item-nm">닉네임</div>
          <div class="item-nm">성별</div>
          <div class="item-nm">생년월일</div>
          <div class="item-nm">전환번호</div>
          <div class="item-nm">상태메세지</div>
        </div>

        <div class="row-ctnt">
          <div class="item-txt"> {{ loginUser.email }} </div>
          <div class="item-txt"> {{ loginUser.nm }} </div>
          <div class="item-txt"> {{ loginUser.nick }} </div>
          <div class="item-txt"> {{ genderTxt }} </div>
          <div class="item-txt"> {{ loginUser.birth }} </div>
          <div class="item-txt"> {{ loginUser.tel }} </div>
          <div class="item-txt"> {{ loginUser.cmt }} </div>
        </div>
      </div>

      <div>
        <router-link :to="{ path: '/myaccountmod' }">
          <button type="button">회원정보 수정</button>
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
.my-account {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.container{
  color: var(--maincolor);
  /* display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column; */
}
.myaccount-profile {
  display: flex;
  line-height: 40px;
  justify-content: center;
  padding: 50px;
}
.row {
  display: flex;
  flex-direction: column;
  text-align: left;
  padding-right: 20px;
}
.row-ctnt {
  display: flex;
  flex-direction: column;
  text-align: left;
  /* padding-right: 20px; */
}
/* .item{
  background-color: var(--maincolor);
  color: #fff;
  margin: 10px;
  padding: 10px;
  height: 5vh;
  display: flex;
  align-items: center;
  width: 50vh;
} */

</style>
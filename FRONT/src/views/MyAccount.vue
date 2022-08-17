<template>
  <div class="my-account bolder">
    <div class="container">
      <h1 class="bolder" style="margin-bottom: 50px;">회원정보</h1>
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
          <button class="edit-btn" type="button">회원정보 수정</button>
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
}
.myaccount-profile {
  border: 2px solid var(--mainOrange);
  border-radius: 15px;
  width: 30vw;
  margin: 0 auto;
  display: flex;
  line-height: 40px;
  justify-content: space-evenly;
  padding: 50px;
  font-size: 1.2rem;
}
.row {
  display: flex;
  flex-direction: column;
  text-align: left;
  padding-right: 30px;
}
.row-ctnt {
  display: flex;
  flex-direction: column;
  text-align: left;
  /* padding-right: 20px; */
}
.item-txt {
	text-decoration: underline;
  text-underline-position: under;
}
.edit-btn { 
  margin-top: 50px;
  display: inline-block;
  text-decoration: none;
  background: #fff;
  padding: 8px 20px;
  border-radius: 7px;
  font-weight: bolder;
  color: var(--maincolor);
  box-shadow: 0 8px 0 var(--mainDark);
  transition: all 0.2s;
  border: 1px solid var(--maincolor);
}
.edit-btn:hover {
  background-color: var(--maincolor);
  color: #fff;
}
.edit-btn:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 var(--maincolor);
}


</style>
<template>
  <div class="location">
    <div class="container">
      <h1>Myaccount</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진<input type="text" placeholder="">{{ selUser.profile_img }}</div>
        <div class="myaccount_profile_txt">
          <div>이메일 : {{ selUser.email }} </div><i class="fa-light fa-pencil"></i>
          <div>비밀번호 : </div>
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


<div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        사진 : {{ selUser.profile_img }}
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">클릭시 사진을 변경</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        이메일 : {{ selUser.email }}
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">클릭시 이메일 변경</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
    </div>
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
  width: 65vw;
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
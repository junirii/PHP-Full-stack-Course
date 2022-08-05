<template>
  <div class="location">
    <div class="container">
      <h1>Myaccount mod</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img click">사진<input v-model="selUser.profile_img"><button>수정</button></div>
        <div class="myaccount_profile_txt">
          <div>이메일 : <input v-model="selUser.email"><button>수정</button>
          </div>
          <div>비밀번호 : </div>
          <div>이름 : <input v-model="selUser.nm"><button>수정</button></div>
          <div>닉네임 : <input v-model="selUser.nick"><button>수정</button></div>
          <div>성별 : <input v-model="selUser.gender"><button>수정</button></div>
          <div>생년월일 : <input v-model="selUser.birth"><button>수정</button></div>
          <div>전화번호 : <input v-model="selUser.tel"><button>수정</button></div>
          <div>상태메세지 : <input v-model="selUser.cmt"><button>수정</button></div>
        </div>
      </div>
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
    async modMyAccount() {
      divClassClick.document.querySelector('.click');

    }
  },
  created() {
    this.getMyAccount();
    this.modMyAccount();
  }
}
</script>

<style scoped>

.myaccount_profile {
  border: 1px solid grey;
  border-radius: 5px;
  /* width: 65vw; */
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

.display_h {
  display: none
}

.display_i {
  display: inline
}
</style>
<template>
  <div class="location">
    <div class="container">

      <h1>회원정보 수정</h1>
      <div class="myaccount_profile">
        <div class="myaccount_profile_img">사진<input type="file"></div>
        <div class="myaccount_profile_txt">
          <div>이메일 : <input type="email" v-model="loginUser.email"></div>
          <div>비밀번호 : <input type='button' value='비밀번호 변경' id='btn3' @click="clickBtn1">

            <div>
              <input type='password' v-model="pw" id='btn1' style="display:none;" placeholder="새 비밀번호">
            </div>
            <div>
              <input type='password' v-model="pwCheck" id='btn2' style="display:none;" placeholder="새 비밀번호 확인">
            </div>

          </div>
          <input type='button' value='취소' id='btn4' @click="clickBtn2" style="display:none;">
        </div>

        <div>이름 : <input type="text" v-model="loginUser.nm"></div>
        <div>닉네임 : <input type="text" v-model="loginUser.nick"></div>
        <div>성별 :
          <input v-model="loginUser.gender" type="radio" id="male" name="gender" value="1"
            checked="this.loginUser.gender == 1 ? ='checked' : =''">
          <label for="male">남성</label>
          <input v-model="loginUser.gender" type="radio" id="female" name="gender" value="2">
          <label for="female">여성</label>
        </div>
        <div>생년월일 : <input type="date" v-model="loginUser.birth"></div>
        <div>전화번호 : <input type="tel" v-model="loginUser.tel"></div>
        <div>상태메세지 : <input type="text" v-model="loginUser.cmt"></div>
      </div>


      <div>
        <button type="submit" @click="myAccountMod">수정</button>
        <button type="reset">취소</button> <!-- reset 안먹힘다-->
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
      pw: '',
      pwCheck: ''


    }
  },
  methods: {
    async getMyAccount() { // iuser
      // console.log(this.$store.state.user);
      this.loginUser = this.$store.state.user;
    },
    async myAccountMod() {
      /*마이페이지 댓글 참고.....*/
      const res = await this.$post('/user/myAccountMod', {
        profile_img: this.loginUser.profile_img,
        email: this.loginUser.email,
        pw: this.pw,
        pwCheck: this.pwCheck,
        nm: this.loginUser.nm,
        nick: this.loginUser.nick,
        gender: this.loginUser.gender,
        birth: this.loginUser.birth,
        tel: this.loginUser.tel,
        cmt: this.loginUser.cmt,
        iuser: this.loginUser.iuser
      });
      console.log(res);
      if (res.result === 1) {
        this.$store.state.user = this.loginUser;
        this.$router.push({ name: 'myaccount' });
      }
    },

    // // 아아아아아아아아아아아아아아아아악 하고야만다아아아아아아아아아악

    // 비밀번호 변경버튼
    clickBtn1() {
      const btn1 = document.getElementById('btn1');
      const btn2 = document.getElementById('btn2');
      const btn3 = document.getElementById('btn3');
      const btn4 = document.getElementById('btn4');

      if (btn1.style.display !== 'none' && btn2.style.display !== 'none') {
        btn1.style.display = 'none';
        btn2.style.display = 'none';
        btn3.style.display = 'inline';
        btn4.style.display = 'none';
      }
      else {
        btn1.style.display = 'inline';
        btn2.style.display = 'inline';
        btn3.style.display = 'none';
        btn4.style.display = 'inline';
      }
    },

  },
  // 비밀번호 취소버튼
  clickBtn2() {
    const btn1 = document.getElementById('btn1');
    const btn2 = document.getElementById('btn2');
    const btn3 = document.getElementById('btn3');
    const btn4 = document.getElementById('btn4');

    btn1.style.display = 'none';
    btn2.style.display = 'none';
    btn3.style.display = 'inline';
    btn4.style.display = 'none';

  },

  // 비밀번호 확인버튼
  chgPw() {
    if (this.pw1 === this.pw2) {
      this.pw2 = this.loginUser.pw;
    }

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
<template>
  <div class="myaccount-mod">
    <div class="container">
      <h1 class="bolder" style="margin-bottom: 50px;">회원정보 수정</h1>
      <div class="myaccount-profile">
        <div class="row">
          <div class="item-nm">이메일</div>
          <div class="item-nm">비밀번호</div>
          <div class="item-nm">비밀번호 확인</div>
          <div class="item-nm">이름</div>
          <div class="item-nm">닉네임</div>
          <div class="item-nm">성별</div>
          <div class="item-nm">생년월일</div>
          <div class="item-nm">전환번호</div>
          <div class="item-nm">상태메세지</div>
        </div>

        <div class="row-ctnt">
          <div class="item-txt"> {{ loginUser.email }} </div>
          <div class="item-txt">
            <!-- <input type='button' v-if="!pwShow" value='비밀번호 변경' @click="showPw"> -->
            <span style="color: var(--maincolor);">
              <input class="input bolder" type='password' v-model="pw" placeholder="새 비밀번호">
            </span>
          <div class="item-txt">
            <span>
              <input class="input" type='password' v-model="pwCheck" placeholder="새 비밀번호 확인">
            </span>
          </div>
            <!-- <input type='button' v-if="pwShow" value='취소' @click="cancel"> -->
            <!-- <div v-if="pwShow"> -->
              <div v-show="pw!=='' && pw===pwCheck">비밀번호가 일치합니다.</div>
              <div v-show="pw!==pwCheck">비밀번호가 일치하지 않습니다.</div>
            <!-- </div> -->
          </div>
          <div class="item-txt"> {{ loginUser.nm }} </div>
          <div class="item-txt"><input type="text" v-model="loginUser.nick"></div>
          <div class="item-txt"> {{ genderTxt }} </div>
          <div class="item-txt"> {{ loginUser.birth }} </div>
          <div class="item-txt"><input type="tel" v-model="loginUser.tel"></div>
          <div class="item-txt"><input type="text" v-model="loginUser.cmt"></div>
        </div>
      </div>


      <div>
        <button type="button" @click="myAccountMod" 
        v-bind:disabled="pwShow && (pw !== pwCheck || pwCheck === '')">수정</button>
        <!-- <router-link :to="{ path: '/MyAccount' }"><button>취소</button></router-link> -->
        <button type="button" @click="goToMyAccount">취소</button>
        <button type="button">회원탈퇴</button>
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
      pwCheck: '',
      pwShow: false,
      genderTxt: ''
    }
  },
  methods: {
    async getMyAccount() { // iuser
      // console.log(this.$store.state.user);
      this.loginUser = JSON.parse(JSON.stringify(this.$store.state.user));
      if(this.loginUser.gender == 1) {
        this.genderTxt = '남성';
      } else {
        this.genderTxt = '여성';
      }
      console.log(this.loginUser);
    },
    async myAccountMod() {
      // 회원정보 수정 (마이페이지 댓글 참고)
      if(this.pw && this.pwCheck){
        this.loginUser.pw = this.pw;
        this.loginUser.pwCheck = this.pwCheck;
      };
        const res = await this.$post('/user/myAccountMod', this.loginUser);
        console.log(res);
        if (res.result === 1) {
          this.$store.state.user = this.loginUser;
          this.$router.push({ name: 'myaccount' });
        }
      },
    showPw() {
      this.pwShow = true;
    },

    // 비밀번호 취소버튼
    cancel() {
      this.pwShow = false;
      this.pw = '';
      this.pwCheck = '';
    },

    // 전체페이지 취소버튼 (myaccount페이지로 가도록, DB입력은 되지않으나, front에서 띄워짐ㅠㅠ)
    goToMyAccount() {
      this.$router.push({ name: 'myaccount' });

    }
    // 비밀번호 변경버튼
  },
  created() {
    this.getMyAccount();
  }
}
</script>

<style scoped>
.myaccount-mod {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.container {
  color: var(--maincolor);
  width: 100vh;
}

.myaccount-profile {
  border: 2px solid var(--mainOrange);
  border-radius: 15px;
  width: 50vw;
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
  padding-right: 35px;
  line-height: 41px;
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
input, .input {
  border: none;
  border-bottom: 1px solid var(--maincolor);
  color: var(--maincolor);
}
input:focus {
  border: none;
  border-bottom: 1px solid var(--maincolor);
  /* border-radius: 10px; */
}
input {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;

  border: none;
  border-bottom: 1px solid var(--maincolor);
  color: var(--maincolor);
  font-weight: bolder;
  width: 120px;
  height: 25px;
  /* padding-left: 10px; */
  color: var(--maincolor);
}
input::-ms-expand { display: none; }
input:hover {
  /* border-bottom: 1px solid var(--mainDark); */
  cursor: pointer;    
}

</style>
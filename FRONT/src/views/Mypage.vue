<template>
  <div class="location">
    <div class="container">
      <h1>Mypage</h1>
      <!-- 마이페이지 섹션1 - 프로필 -->
      <div class="mypage_profile">
        <div class="mypage_profile_img">사진{{ selUser.profile_img }}</div>
        <div class="mypage_profile_txt">
          <div>닉네임 : {{ selUser.nick }}</div>
          <div>상태메세지 : {{ selUser.cmt }}</div>
          <div><i class="fa-regular fa-paper-plane"></i>DM</div>
          <div><i class="fa-solid fa-heart"></i>인기도</div>
        </div>
      </div>
      <br>

      <!-- 마이페이지 섹션2 - 찜한 여행, 호스팅한 여행 , 참여한 여행-->
      <div v-if="feedIuser == loginIuser">
        <div class="title">찜한 여행</div>
        <div>
          <div :key="item.itravel" v-for="item in myPageTravelFav" @click="goToDetailFromMyPage(item.itravel)">
            {{ item.itravel }} {{ item.title }}
          </div>
        </div>
      </div>
      <br>

      <div>
        <div class="title">호스팅한 여행</div>
        <div :key="item.itravel" v-for="item in myPageHost" @click="goToDetailFromMyPage(item.itravel)">
          <div>{{ item.title }}</div>
        </div>
      </div>
      <br>

      <div>
        <div class="title">참여한 여행</div>
        <div :key="item.itravel" v-for="item in myPageTravelState" @click="goToDetailFromMyPage(item.itravel)">
          <span>{{ item.title }}</span>
        </div>
      </div>
      <br>

      <!-- 마이페이지 섹션3 - 리뷰-->

      <div>
        <div class="title"><i class="fa-solid fa-comment"></i>리뷰</div>
        <div :key="item.icmt" v-for="item in myPageCmt">
          <span>{{ item.title }} {{ item.cmt }} {{ item.profile_img }} {{ item.nick }} {{ item.reg_dt }} </span>
        </div>

        <div>
          <select v-model="selectedTravel">
            <option value="" selected>참여한 여행(selected 안됨)</option>
            <option :value="item.itravel" :key="item.itravel" v-for="item in guestTravel">{{ item.title }}</option>
          </select>
          <input v-model="cmt" type="textarea" @keyup="enter($event)">
          <input type="submit" value="등록" @click="insCmt">
        </div>
      </div>
    </div> <!-- container 닫기 -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      myPageTravelFav: [],
      myPageHost: [],
      myPageTravelState: [],
      myPageCmt: [],
      selUser: {},
      guestTravel: [],
      selectedTravel: null,
      feedIuser: 0,
      loginIuser: 0,
      cmt: ''
    }
  },
  methods: {
    async getMyPage() { // iuser
      console.log(this.$store.state.user);
      this.feedIuser = this.$store.state.feedIuser;
      this.loginIuser = this.$store.state.user.iuser;
      console.log('feedIuser : ' + this.feedIuser);
      console.log('loginIuser : ' + this.loginIuser);

      this.data = await this.$get(`/user/myPage/${this.feedIuser}/${this.loginIuser}`, {}); // controllers / method
      console.log(this.data);
      this.myPageTravelFav = this.data.result.myPageTravelFav;
      this.myPageHost = this.data.result.myPageHost;
      this.myPageTravelState = this.data.result.myPageTravelState;
      this.selUser = this.data.result.selUser;
      this.guestTravel = this.data.result.guestTravel;
    },
    async goToDetailFromMyPage(itravelNum) { // 클릭시 여행게시물로 이동
      this.$store.state.itravel = itravelNum;
      this.$router.push({ name: 'detail' });
    },
    async insCmt() { // 댓글삽입기능
      const res = await this.$post('/user/insCmt', {
        itravel: this.selectedTravel,
        guest_iuser: this.loginIuser,
        cmt: this.cmt
      });
      console.log(res.result);
      if (res.result === 1) {
        this.selectedTravel = 0;
        this.cmt = '';
        this.getCmt();
      }
    },
    async getCmt() {
      const res = await this.$get(`/user/getCmt/${this.feedIuser}`, {});
      console.log(res.result)
      if (res) {
        this.myPageCmt = res.result;
      }
    },
    enter(e) {
      if (e.key === 'Enter') {
        this.insCmt();
      }
    }
  },
  created() {
    this.getMyPage();
    this.getCmt();
  }
}

</script>

<style scoped>
/* css 한거 아님 보기편하게 하려고 임시로 해놓은거임 구리다고 뭐라하지마세여.. */

.location {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}

.title {
  background-color: rgb(170, 170, 170);
  border: 1px solid rgb(170, 170, 170);
  border-radius: 5px;
  padding: 5px;
  margin: 5px;
  color: #fff;
}

.title :hover {
  background-color: rgb(192, 192, 192);
}

.mypage_profile {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

/* .mypage_profile .mypage_profile_img {
    display: flex;    
} */

.mypage_profile .mypage_profile_txt {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
</style>

<!-- console.log(this.$store.state.user); // 로그인한 유저정보가 담겨져 있음 -->
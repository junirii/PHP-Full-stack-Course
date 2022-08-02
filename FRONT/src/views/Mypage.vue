<template>
  <div class="container">
    <!-- 마이페이지 섹션1 - 프로필 -->
    <div class="mypage_profile">
      <div class="mypage_profile_img">사진{{ selUser.profile_img }}</div>
      <div class="mypage_profile_txt">
        <div>닉네임 : {{ selUser.nick }}
          <input type="button" value="프로필편집">
        </div>
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
        <div :key="item.iboard" v-for="item in myPageBoardFav" @click="goToDetailFromMyPage(item.iboard)">
          {{ item.iboard }} {{ item.title }}
        </div>
      </div>
    </div>
    <br>

    <div>
      <div class="title">호스팅한 여행</div>
      <div :key="item.iboard" v-for="item in myPageHost" @click="goToDetailFromMyPage(item.iboard)">
        {{ item.title }}
      </div>
    </div>
    <br>

    <div>
      <div class="title">참여한 여행</div>
      <div :key="item.iboard" v-for="item in myPageTrip" @click="goToDetailFromMyPage(item.iboard)">
        {{ item.title }}
      </div>
    </div>
    <br>

    <!-- 마이페이지 섹션3 - 리뷰-->

    <!-- <div>
    <div class="title"><i class="fa-solid fa-comment"></i>리뷰</div>
    <div :key="item.icmt" v-for="item in myPageCmt">
    <span>{{item. profile_img}} {{ item.nick }} {{ item.cmt }} {{ item.reg_dt }} </span>
    </div>
    <div><input type="textarea">
    <input type="submit" value="등록"></div>
    </div> -->

  </div> <!-- container 닫기 -->
</template>

<script>
export default {
  data() {
    return {
      data: [],
      myPageBoardFav: [],
      myPageHost: [],
      myPageTrip: [],
      myPageCmt: [],
      selUser: {},
      feedIuser: 0,
      loginIuser: 0
    }
  },
  methods: {
    async getMyPage() { // iuser
      console.log(this.$store.state.user);
      this.feedIuser = this.$route.params.iuser;
      this.loginIuser = this.$store.state.user.iuser;
      console.log('feedIuser : ' + this.feedIuser);
      console.log('loginIuser : ' + this.loginIuser);

      this.data = await this.$get(`/user/myPage/${this.feedIuser}`, {}); // controllers / method
      this.myPageBoardFav = this.data.result.myPageBoardFav;
      this.myPageHost = this.data.result.myPageHost;
      this.myPageTrip = this.data.result.myPageTrip;
      this.myPageCmt = this.data.result.myPageCmt;
      this.selUser = this.data.result.selUser;
    },
    async goToDetailFromMyPage(iboardNum) { // 클릭시 여행게시물로 이동
      this.$router.push({name: 'detail', params: {iboard: iboardNum}});
    },
    // async comment() { // 댓글기능
    //   const comment = await this.$post('/user/comment', {
    //     hostiuser = 
    //   });
    // }
  },
  created() {
    this.getMyPage();
  }
}

</script>

<style scoped>
/* css 한거 아님 보기편하게 하려고 임시로 해놓은거임 구리다고 뭐라하지마세여.. */
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
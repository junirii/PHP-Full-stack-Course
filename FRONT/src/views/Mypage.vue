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
        <div :key="item.iboard" v-for="item in myPageBoardFav">
          {{ item.iboard }} {{ item.title }}
        </div>
      </div>
    </div>
    <br>

    <div>
      <div class="title">호스팅한 여행</div>
      <div :key="item.iboard" v-for="item in myPageHost">
        <div>{{ item.title }}</div>
      </div>
    </div>
    <br>

    <div>
      <div class="title">참여한 여행</div>
      <div :key="item.iboard" v-for="item in myPageTrip">
        <span>{{ item.title }}</span>
      </div>
    </div>
    <br>

    <!-- 마이페이지 섹션3 - 리뷰-->
    <!-- <div> -->
    <!-- <div class="row">리뷰</div> -->
    <!-- <div :key="item.icmt" v-for="item in myPageCmt"> -->
    <!-- <span>{{ item.cmt }}</span> -->
    <!-- </div> -->
    <!-- </div> -->
    <div class="card">
      <div class="card-header bg-dark text-white"><i class="fa-solid fa-comment"></i>댓글</div>
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <div class="form-inline mb-2">
              <i class="fa-solid fa-user"></i><input type="text" class="form-control ml-2" placeholder="Enter yourId"
                id="replyId">
              <i class="fa-solid fa-unlock"></i><input type="password" class="form-control ml-2"
                placeholder="Enter password" id="replyPassword">
            </div>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            <button type="button" class="btn bg-dark text-white mt-3" onClick="javascript:addReply();">댓글 작성</button>
          </li>
        </ul>
      </div>
    </div>


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
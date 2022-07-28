<template>
  <div class="container">
    <!-- 마이페이지 섹션1 - 프로필 -->
    <div :key="item.iuser" v-for="item in myPagehost">
      <div class="row">사진 : {{ item.profile_img }}</div>
      <div>
        <div>닉네임 : {{ item.nick }}
          <input type="button" value="프로필편집">
        </div>
        <div>상태메세지 : {{ item.cmt }}</div>
        <div><i class="fa-regular fa-paper-plane"></i>DM {{ }}</div>
        <div><i class="fa-solid fa-heart"></i>인기도 {{ }}</div>
      </div>
    </div>
    <br>

    <!-- 마이페이지 섹션2 - 찜한 여행, 호스팅한 여행 , 참여한 여행-->
    <div>
      <div class="row">찜한 여행</div>
      <div :key="item.iuser" v-for="item in myPageBoardFav">
        <span>{{ item.iboard }}</span>
        <span>{{ item.title }}</span>
      </div>
    </div>
    <br>

    <div>
      <div class="row">호스팅한 여행</div>
      <div :key="item.iuser" v-for="item in myPagehost">
        <div>{{ item.title }}</div>
      </div>
    </div>
    <br>

    <div>
      <div class="row">참여한 여행</div>
      <div :key="item.iuser" v-for="item in myPageTrip">
        <span>{{ item.title }}</span>
      </div>
    </div>
    <br>

    <!-- 마이페이지 섹션3 - 리뷰 -->
    <div>
      <div class="row">리뷰</div>
      <div :key="item.iuser" v-for="item in myPageCmt">
        <span>{{ item.cmt }}</span>
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
      myPagehost: [],
      myPageTrip: [],
      myPageCmt: [],
    }
  },
  methods: {
    async getMyPage() { // iuser
      const iuser = this.$route.params.iuser;
      this.data = await this.$get(`/user/myPage/${iuser}`, {}); // controllers / method
      console.log(this.data);
      this.myPageBoardFav = this.data.result.myPageBoardFav;
      this.myPagehost = this.data.result.myPagehost;
      this.myPageTrip = this.data.result.myPageTrip;
      this.myPageCmt = this.data.result.myPageCmt;
    },

  },
  created() {
    this.getMyPage();
    // console.log(this.$store.state.user); // 로그인한 유저정보가 담겨져 있음

  }
}

</script>

<style>
/* .col {
  background-color: rgb(170, 170, 170);
  border: 1px solid rgb(170, 170, 170);
  border-radius: 5px;
  padding: 5px;
  margin: 5px;
  color: #fff;
}
.col :hover {
  background-color: rgb(192, 192, 192);
} */
</style>
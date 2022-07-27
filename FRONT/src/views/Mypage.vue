<template>
  <div class="container">
    <!-- 마이페이지 섹션1 - 프로필 -->
    <div class="row">
      <div class="col">사진 : {{ this.$store.state.user.profile_img }}</div>
      <div class="col">
        <div>닉네임 : {{ this.$store.state.user.nick }}
        <input type="button" value="프로필편집"></div>
        <div>상태메세지 : {{ this.$store.state.user.cmt }}</div>
        <div><i class="fa-regular fa-paper-plane"></i>DM {{ }}</div>
        <div><i class="fa-solid fa-heart"></i>인기도 {{ }}</div>
      </div>
    </div>
    <br>

    <!-- 마이페이지 섹션2 - 호스팅한 여행 , 참여한 여행-->
    <div>
      <div>호스팅한 여행</div>
        <div :key="item.iuser" v-for="item in myPagehost1">
          <span>{{ item.title }}</span>
        </div>
    </div>
    <br>

    <div>
      <div>참여한 여행</div>
        <div :key="item.iuser" v-for="item in myPageTrip2">
          <span>{{ item.title }}</span>
        </div>
    </div>
    <br>

    <!-- 마이페이지 섹션3 - 리뷰 , 찜한 여행-->
    <div class="row">
      <div class="col">
        <div>리뷰</div> <!-- QQ 댓글게시판 만들여야함ㅠㅠ.. 익명상태.. -->
        <div :key="item.iuser" v-for="item in myPageCmt3">
          <span>{{ item.cmt }}</span>
        </div>


      </div>
      <div class="col">
        <div>찜한 여행</div>
        <div :key="item.iuser" v-for="item in myPageBoardFav4">
          <span>{{ item.iboard }}</span>
          <span>{{ item.title }}</span>
        </div>
      </div>
    </div>
  </div> <!-- container 닫기 -->
</template>

<script>
export default {
  data() {
    return {
      data: [],
      myPagehost1: [],
      myPageTrip2: [],
      myPageCmt3: [],
      myPageBoardFav4: []
    }
  },
  methods: {
    async getMyPage() { // iuser
      const iuser = this.$store.state.user.iuser;
      this.data = await this.$get(`/user/myPage/${iuser}`, {}); // controllers / method
      console.log(this.data);
      this.myPagehost1 = this.data.result.myPagehost1;
      this.myPageTrip2 = this.data.result.myPageTrip2;
      this.myPageCmt3 = this.data.result.myPageCmt3;
      this.myPageBoardFav4 = this.data.result.myPageBoardFav4;
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
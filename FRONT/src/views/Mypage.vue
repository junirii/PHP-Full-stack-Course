<template>
  <div class="container">
    <!-- 마이페이지 섹션1 - 프로필 -->
    <div class="row">
      <div class="col">사진 : {{ this.$store.state.user.profile_img }}</div>
      <div class="col">
        <div>닉네임 : {{ this.$store.state.user.nick }}</div>
        <div>상태메세지 : {{ this.$store.state.user.cmt }}</div>
        <div>DM {{ }}</div>
        <div>인기도 {{}}</div>
      </div>
    </div>
    <br>
    <!-- 마이페이지 섹션2 - 호스팅한 여행 , 참여한 여행-->
    <div>호스팅한 여행 {{ }}</div>
    <div>참여한 여행 {{ }}</div>
    <br>
    <!-- 마이페이지 섹션3 - 리뷰 , 찜한 여행-->
    <div class="row">
      <div class="col">리뷰 {{ }}</div>
      <div class="col">찜한 여행 {{ }}</div>
    </div>
  </div> <!-- container 닫기 -->
</template>

<script>
export default {
  data() {
    return {
      data: {}
    }
  },
  methods: {
    async getMyPage() {
      const iuser = this.$store.state.user;
      this.data = await this.$get(`/user/myPage/${iuser}`, {}); // controllers / method
      console.log(this.data);
    }
  },
  created() {
    this.getMyPage();
    console.log(this.$store.state.user);
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


<!--
  - 로그인한 유저정보가 담겨져있음
  this.$store.state.user

  - 통신으로 보내고(2번째 인자), get json으로 받아오기
-->

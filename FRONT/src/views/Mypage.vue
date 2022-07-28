<template>
  <div class="container">
    <!-- 마이페이지 섹션1 - 프로필 -->
    <div>
      <div>사진 {{ data.profile_img }}</div>
      <div>
        <div>닉네임 : {{ data.nm }}</div>
        <div>상태메세지 : {{ data.cmt }}</div>
        <div><svg id="dmIcon" aria-label="다이렉트 메시지" class="_8-yf5 pointer" color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="22" x2="9.218" y1="3" y2="10.083"></line><polygon fill="none" points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></polygon></svg>DM</div>
        <div><svg xmlns="http://www.w3.org/2000/svg" id="heart" onclick="icon" width="20" height="20"
                fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                <path
                  d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" /></svg>인기도</div>
      </div>
    </div>
    <br>
    <!-- 마이페이지 섹션2 - 호스팅한 여행 , 참여한 여행-->
    <div>호스팅한 여행</div>
    <div>참여한 여행</div>
    <br>
    <!-- 마이페이지 섹션3 - 리뷰 , 찜한 여행-->
    <div>리뷰</div>
    <div>찜한 여행</div>
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
      const iuser = this.$route.query.iuser;
      this.data = await this.$get(`/user/myPage/${iuser}`, {}); // controllers / method
    }
  },
  created() {
    this.getMyPage();
  }
}

</script>

<style>
</style>
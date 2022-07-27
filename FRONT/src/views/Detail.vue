<template>
  <div class="container">
    <!-- 디테일 섹션1 - 간단 정보(필터)-->
    <div>{{ data.main_img }}</div>
    <div>
      <div>지역 : {{ data.area }} / {{ data.location }}</div>
      <div>기간 : {{ data.s_date }} ~ {{ data.e_date }}</div>
      <div>성별 : {{ data.f_people }}</div>
      <div>연령 : {{ data.f_age }}</div>
      <div>인원 : {{ data.f_people }}</div>
      <div>비용 : {{ data.f_price }}</div>
    </div>
    <br>


    <!-- 디테일 섹션2 - 호스트 정보-->
    <div>
      <div>{{ data.profile_img }}</div>
      <div>
        <div>{{ data.nm }}</div>
        <div>{{ data.cmt }}</div>
      </div>
    </div>
    <br>

    <nav>
      <router-link to="/detail">상세 정보</router-link> |
      <router-link to="/chat" @click="goToChat">채팅</router-link> |
    </nav>

    <!-- 디테일 섹션3 - 상세 정보-->
    <div>
      <div>일정</div>
      <div>
        <div>{{ data.day }}</div>
        <div>{{ data.img }}</div>
        <div>{{ data.ctnt }}</div>
      </div>
    </div>
    <br>

    <div>
      <input type="button" value="찜하기">
      <router-link :to="{ path: '/Mypage' }">
        <button type="button">신청하기</button>
      </router-link>
    </div>
  </div> <!-- container 닫기 -->
</template>

<script>
export default {
  data() {
    return {
      data: [],
      iboard: ''
    }
  },
  methods: {
    async getDetail() {
      this.iboard = this.$route.params.iboard; // iboard 가져옴
      this.data = await this.$get(`/board/detail/${this.iboard}`, {}); // controllers / method / 가져온iboard
      // console.log(detail);
    },
    goToChat(){
      this.$router.push({name: 'chat', params: {iboard: this.iboard}});
    }
  },
  created() {
    this.getDetail();
  }
}

</script>

<style>
</style>
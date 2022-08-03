<template>
  <div class="create_box"></div>
  <div class="container">
    <!-- 디테일 섹션1 - 간단 정보(필터)-->
    <div class="row">
      <div class="col">메인이미지 : {{ data.travelData.main_img }}</div>
      <div class="col">
        <div>{{ data.hostUser.title }}</div>
        <div>지역 : {{ data.travelData.area }} / {{ data.travelData.location }}</div>
        <div>기간 : {{ data.travelData.s_date }} ~ {{ data.travelData.e_date }}</div>
        <div>성별 : {{ data.travelData.f_people }}</div>
        <div>연령 : {{ data.travelData.f_age }}</div>
        <div>인원 : {{ data.travelData.f_people }}</div>
        <div>비용 : {{ data.travelData.f_price }}</div>
      </div>
    </div>
    <br>

    <!-- 디테일 섹션2 - 호스트 정보-->
    <div class="row">
      <div class="col">{{ data.hostUser.profile_img }}</div>
      <div class="col">
        <div>{{ data.hostUser.nm }}</div>
        <div>{{ data.hostUser.cmt }}</div>
      </div>
    </div>
    <br>

    <!-- 디테일 섹션3 - 상세 정보-->
    <!-- <div :key="data.iboard" v-for="data in list">
      <div>일정</div>
      <div class="row">
        <div class="col">{{ data.day }}</div>
        <div class="col">{{ data.img }}</div>
        <div class="col">{{ data.ctnt }}</div>
      </div>
    </div>
    <br> -->

    <div class="accordion" id="accordionPanelsStayOpenExample">
      <div class="accordion-item" :key="idx" v-for="(dayObj, idx) in data.day">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseOne1" aria-expanded="true"
            aria-controls="panelsStayOpen-collapseOne">
            DAY {{ dayObj.day }}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOne1" class="accordion-collapse collapse show"
          aria-labelledby="panelsStayOpen-headingOne" :key="idx" v-for="(item, idx) in data.ctnt">
          <div v-if="dayObj.day == item.day" class="accordion-body">
            <strong>{{ item.img }}</strong>{{ item.ctnt }} {{dayObj.day}} {{item.day}} It is shown by default, until the collapse plugin adds the
            appropriate classes that we use to style each element. These classes control the overall appearance, as well
            as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our
            default variables. It's also worth noting that just about any HTML can go within the
            <code>.accordion-body</code>, though the transition does limit overflow.
          </div>
        </div>
      </div>
    </div>

    <div>
      <input type="button" value="찜하기">
      <input type="submit" value="신청하기">
    </div>
  </div> <!-- container 닫기 -->
</template>

<script>
export default {
  data() {
    return {
      data: [],
    }
  },
  methods: {
    async getDetail() {
      const itravel = this.$store.state.itravel; // itravel 가져옴
      const res = await this.$get(`/travel/detail/${itravel}`, {}); // controllers / method / 가져온itravel
      this.data = res.result;
      console.log(this.data);
    },
    goToChat(){
      this.$router.push({name: 'chat'});
    }
  },
  created() {
    this.getDetail();
  }
}

</script>

<style scoped>
.create_box {
    margin: 0 auto;
    padding: 150px;
}
</style>
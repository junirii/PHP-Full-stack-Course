<template>
  <div class="container">
    <!-- 디테일 섹션1 - 간단 정보(필터)-->
    <div class="row">
      <div class="col">{{ data[0].main_img }}</div>
      <div class="col">
        <div>{{ data[0].title }}</div>
        <div>지역 : {{ data[0].area }} / {{ data[0].location }}</div>
        <div>기간 : {{ data[0].s_date }} ~ {{ data[0].e_date }}</div>
        <div>성별 : {{ data[0].f_people }}</div>
        <div>연령 : {{ data[0].f_age }}</div>
        <div>인원 : {{ data[0].f_people }}</div>
        <div>비용 : {{ data[0].f_price }}</div>
      </div>
    </div>
    <br>

    <!-- 디테일 섹션2 - 호스트 정보-->
    <div class="row">
      <div class="col">{{ data[0].profile_img }}</div>
      <div class="col">
        <div>{{ data[0].nm }}</div>
        <div>{{ data[0].cmt }}</div>
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
      <div class="accordion-item" :key="item.day" v-for="item in data">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseOne1" aria-expanded="true"
            aria-controls="panelsStayOpen-collapseOne">
            DAY {{ item.day }}
          </button>
        </h2>
        <div id="panelsStayOpen-collapseOne1" class="accordion-collapse collapse show"
          aria-labelledby="panelsStayOpen-headingOne">
          <div class="accordion-body">
            <strong>{{ item.img }}</strong>{{ item.ctnt }} It is shown by default, until the collapse plugin adds the
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
      const iboard = this.$route.params.iboard; // iboard 가져옴
      this.data = await this.$get(`/board/detail/${iboard}`, {}); // controllers / method / 가져온iboard
      console.log(this.data);
    }
  },
  created() {
    this.getDetail();
  }
}

</script>

<style scoped>
</style>
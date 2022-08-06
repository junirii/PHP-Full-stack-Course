<template>
<div class="location">
  <div class="container">
    <h1>Detail</h1>

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
    <hr>
    <!-- 디테일 섹션2 - 호스트 정보-->
    <div class="row">
      <div class="col">{{ data.hostUser.profile_img }}</div>
      <div class="col">
        <div>{{ data.hostUser.nick }}</div>
        <div>{{ data.hostUser.cmt }}</div>
      </div>
    </div>
    <br>
    <hr>
    <!-- 디테일 섹션3 - 상세 정보-->

    <div>일정</div>
    <div class="accordion" id="accordionPanelsStayOpenExample">
      <div class="accordion-item" :key="idx" v-for="(dayObj, idx) in data.day">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse"
            :data-bs-target="`#panelsStayOpen-collapseOne${idx}`" aria-expanded="true"
            aria-controls="panelsStayOpen-collapseOne">
            DAY {{ dayObj.day }}
          </button>
        </h2>
        <div :id="`panelsStayOpen-collapseOne${idx}`" class="accordion-collapse collapse show"
          aria-labelledby="panelsStayOpen-headingOne" :key="index" v-for="(item, index) in data.ctnt">
          <div v-if="dayObj.day == item.day" class="accordion-body">
            <strong>{{ item.img }}</strong>{{ item.ctnt }}
          </div>
        </div>
      </div>
    </div>



    <div>
      <input type="button" value="찜하기" @click="insTravelFav">
      <input type="submit" value="신청하기">
    </div>

  </div> <!-- container 닫기 -->
</div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      itravel: null
    }
  },
  methods: {
    async getDetail() {
      this.itravel = this.$store.state.itravel; // itravel 가져옴
      console.log(this.itravel);
      const res = await this.$get(`/travel/detail/${this.itravel}`, {}); // controllers / method / 가져온itravel
      this.data = res.result;
      console.log(this.data);
    },
    goToChat(){
      this.$router.push({name: 'chat'});
    },
    async insTravelFav(){
      const loginIuser = this.$store.state.user.iuser;
      const res = await this.$post(`/travel/travelFav/${loginIuser}/${this.itravel}`, {});
      if(res.result === 1){
        this.$swal.fire('찜 완료!', '', 'success');
      }
    }
  },
  created() {
    this.getDetail();
  }
}

</script>

<style scoped>
.location {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.accordion {
  width: 60vw;
  margin: 0 auto;
}
</style>
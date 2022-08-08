<template>
  <div class="location">
    <div class="container">
      <h1>{{ data.travelData.title }}</h1>

      <!-- 디테일 섹션1 - 간단 정보(필터)-->
      <div class="row">
        <div class="col"><img class="detailMainImg"
            :src="`/static/img/travel/${data.travelData.itravel}/main/${data.travelData.main_img}`"></div>
        <div class="col">
          <div>지역 : {{ data.travelData.area }} / {{ data.travelData.location }}</div>
          <div>기간 : {{ data.travelData.s_date }} ~ {{ data.travelData.e_date }}</div>
          <div>성별 : {{ data.travelData.f_gender }}</div>
          <div>연령 : {{ data.travelData.f_age }}</div>
          <div>인원 : {{ data.travelData.f_people }}</div>
          <div>비용 : {{ data.travelData.f_price }}</div>
        </div>
      </div>
      <br>
      <hr>
      <!-- 디테일 섹션2 - 호스트 정보-->
      <div class="row">
        <div>호스트 정보</div>
        <div class="col">{{ data.hostUser.profile_img }}</div>
        <div class="col">
          <div>닉네임 : {{ data.hostUser.nick }}</div>
          <div>소개글 : {{ data.hostUser.cmt }}</div>
        </div>
      </div>
      <hr>
      <!-- 디테일 섹션3 - 상세 정보-->

      <div>여행 일정</div>
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
            <div v-if="dayObj.day == item.day" class="accordion-body containerCtnt">
              <img class="detailImg containerCtntImg" :src="`/static/img/travel/${item.itravel}/detail/${item.img}`">
              <span class="containerCtntTxt">{{ item.ctnt }}</span>
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

      if (this.data.travelData.f_gender == 1) {
        this.data.travelData.f_gender = '남성';
      } else if (this.data.travelData.f_gender == 2) {
        this.data.travelData.f_gender = '여성';
      } else {
        this.data.travelData.f_gender = '혼성';
      }
    },
    goToChat() {
      this.$router.push({ name: 'chat' });
    },
    async insTravelFav() {
      const loginIuser = this.$store.state.user.iuser;
      const res = await this.$post(`/travel/travelFav/${loginIuser}/${this.itravel}`, {});
      if (res.result === 1) {
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

.col {
  display: flex;
  justify-content: center;
  flex-direction: column;
}

.detailMainImg {
  max-width: 40vw;
}

.detailImg {
  max-width: 20vw;
}

.containerCtnt {
  display: flex;
  background-color: rgb(235, 235, 235);
  margin: 10px;
  border-radius: 5px;
}

.containerCtntImg {
  padding: 20px;
}

.containerCtntTxt {
  padding: 20px;
}
</style>
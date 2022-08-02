<template>
  <div class="detail container">
    <!-- 디테일 섹션1 - 간단 정보(필터)-->
    <div class="row">
      <div class="col">{{ data.main_img }}</div>
      <div class="col">
        <div>{{ data.title }}</div>
        <div>지역 : {{ data.area }} / {{ data.location }}</div>
        <div>기간 : {{ data.s_date }} ~ {{ data.e_date }}</div>
        <div>성별 : {{ data.f_people }}</div>
        <div>연령 : {{ data.f_age }}</div>
        <div>인원 : {{ data.f_people }}</div>
        <div>비용 : {{ data.f_price }}</div>
      </div>
    </div>
    <br>


    <!-- 디테일 섹션2 - 호스트 정보-->
    <div class="row">
      <div class="col">{{ data.profile_img }}</div>
      <div class="col">
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
    <!-- <div>
      <div>일정</div>
      <div class="row">
        <div class="col">{{ data.day }}</div>
        <div class="col">{{ data.img }}</div>
        <div class="col">{{ data.ctnt }}</div>
      </div>
    </div>
    <br> -->


    <div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        DAY {{ data.day }}
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body">
        <strong>{{ data.img }}</strong>{{ data.ctnt }} It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        DAY {{ data.day }}
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">
        <strong>{{ data.img }}</strong>{{ data.ctnt }} It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
        DAY {{ data.day }}
      </button>
    </h2>
    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
      <div class="accordion-body">
        <strong>{{ data.img }}</strong>{{ data.ctnt }} It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
      itravel: ''
    }
  },
  methods: {
    async getDetail() {
      this.itravel = this.$route.params.itravel; // itravel 가져옴
      this.data = await this.$get(`/travel/detail/${this.itravel}`, {}); // controllers / method / 가져온itravel
      // console.log(detail);
    },
    goToChat(){
      this.$router.push({name: 'chat', params: {itravel: this.itravel}});
    }
  },
  created() {
    this.getDetail();
  }
}

</script>

<style scoped>
.detail { 
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
</style>
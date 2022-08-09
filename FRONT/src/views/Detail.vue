<template>
  <div class="location">
    <div class="container">
      <h1>Detail</h1>

      <!-- 디테일 섹션1 - 간단 정보(필터)-->
      <div class="row">
        <div class="col"><img class="detailMainImg"
            :src="`/static/img/travel/${data.travelData.itravel}/main/${data.travelData.main_img}`"></div>
        <div class="col">
          <div class="title">제목 : {{ data.travelData.title }} </div>
          <div>지역 : {{ data.travelData.area_nm }} / {{ data.travelData.location_nm }}</div>
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
        <div class="col">
          <img class="hostImg" :src="`/static/img/profile/${data.hostUser.iuser}/${data.hostUser.profile_img}`"
          onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';" alt="프로필사진"
          @click="showModal" id="profileImg">
        </div>
        <div class="col">
          <div>닉네임 : {{ data.hostUser.nick }}</div>
          <div>소개글 : {{ data.hostUser.cmt }}</div>
        </div>
      </div>
      <hr>
      <button type="button" @click="goToChat" v-if="isChat">채팅</button>
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
          <div :id="`panelsStayOpen-collapseOne${idx}`" class="accordion-collapse collapse show underline"
            aria-labelledby="panelsStayOpen-headingOne" :key="index" v-for="(item, index) in data.ctnt">
            <div v-if="dayObj.day == item.day" class="accordion-body containerCtnt">
              <img class="detailImg containerCtntImg" :src="`/static/img/travel/${item.itravel}/detail/${item.img}`">
              <span class="containerCtntTxt">{{ item.ctnt }}</span>
            </div>
          </div>
        </div>
      </div>


      <div><input class="travelFavBtn" type="button" value="찜하기" @click="insTravelFav"></div>
      <div>
        <div v-if="isJoin">
          <input class="submitBtn" type="submit" value="취소하기" @click="deletestate()">
        </div>
        <div v-else>
          <input class="submitBtn" type="submit" value="신청하기" @click="instate()">
        </div>
      </div>

    </div> <!-- container 닫기 -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      itravel: null,
      loginIuser: null,
      stres: null,
      isJoin: '',
      isChat: null
    }
  },
  methods: {
    goToChat(){
      this.$router.push({name: 'chat'});
    },
    async getDetail() {
      this.itravel = this.$store.state.itravel; // itravel 가져옴
      this.loginIuser = this.$store.state.user.iuser;
      console.log('itravel ' + this.itravel);
      console.log('loginuser ' + this.loginIuser);
      const res = await this.$get(`/travel/detail/${this.itravel}`, {}); // controllers / method / 가져온itravel
      const res2 = await this.$get(`/travel/travelState/${this.loginIuser}/${this.itravel}`, {});
      this.data = res.result;
      this.stres = res2.result.seltravelState.tts;
      this.isChat = res2.result.selIsJoin.isChat;

      if (res2.result.tts) {
        this.isjoin = true;
      } else {
        this.isjoin = false;
      }

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
    },
    async instate() {                  // 컨트롤러이름 // 함수 메소드 // 필요한 값
      const instate = await this.$post(`/user/travelState/${this.loginIuser}/${this.itravel}`, {});
      if(instate.result === 1){
        this.$swal.fire('신청 되었습니다.', '', 'success')
        .then(async result => {
          if(result.isConfirmed){
            this.isJoin = true;
          }
        });
      }else{
        this.$swal.fire('신청할 수 없습니다.', '', 'error');
      }
    },
    async deletestate() {
      const deletestate = await this.$delete(`/user/travelState/${this.loginIuser}/${this.itravel}`, {});
      if(deletestate.result === 1){
        this.$swal.fire('신청 취소되었습니다.', '', 'success')
        .then(async result => {
          if(result.isConfirmed){
            this.isJoin = false;
          }
        });
      }else{
        this.$swal.fire('취소할 수 없습니다.', '', 'error');
      }
    },
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

.container {
  color: blue;
}

.title {
  color: #fff;
  background-color: blue;
  padding: 20px;
}

.hostImg {
  width: 300px;
  height: 300px;
  object-fit: cover;
  border-radius: 50%;
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
  max-height: 50vh;
}

.detailImg {
  max-width: 20vw;
}

.containerCtnt {
  display: flex;
  background-color: #fff;
  border-bottom: 1px solid blue;
}

.containerCtntImg {
  padding: 20px;
}

.containerCtntTxt {
  padding: 20px;
}

.accordion-item {
  border: 1px solid #fff;
}

.accordion-button {
  background-color: white;
  color: blue;

}

.accordion-button:not(.collapsed) {
  background-color: #fff;
  box-shadow: inset 0 -1px 0 rgba(255, 0, 0, 0.13);
}



.travelFavBtn {
  position: fixed;
  bottom: 222px;
  right: 220px;
  width: 80px;
  height: 80px;
  z-index: 10;

  border-radius: 50%;
  width: 100px;
  height: 100px;
  border: 0px;
  background-color: var(--maincolor);
  color: white;
  font-weight: bold;
  box-shadow: 0 8px 8 #285d92;
}

.travelFavBtn:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 #2d7ac2;
}

.submitBtn {
  position: fixed;
  bottom: 111px;
  right: 220px;
  width: 80px;
  height: 80px;
  z-index: 10;

  border-radius: 50%;
  width: 100px;
  height: 100px;
  border: 0px;
  background-color: var(--maincolor);
  color: white;
  font-weight: bold;
  box-shadow: 0 8px 8 #285d92;
}

.submitBtn:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 #2d7ac2;
}
</style>
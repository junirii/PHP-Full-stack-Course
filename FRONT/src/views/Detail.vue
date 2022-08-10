<template>
  <div class="location">
    <div class="container">
      <h1>Detail</h1>

      <!-- 디테일 섹션1 - 간단 정보(필터)-->
      <div class="section-container-filter">
        <div><img class="detail-main-img"
            :src="`/static/img/travel/${data.travelData.itravel}/main/${data.travelData.main_img}`"></div>
        <div class="section-item-filter">
          <div class="title-filter">제목 : {{ data.travelData.title }} </div><br><br>
          <div v-if="!(data.travelData.location_nm)">지역 : {{ data.travelData.area_nm }}</div>
          <div v-else>지역 : {{ data.travelData.area_nm }} / {{ data.travelData.location_nm }}</div>
          <div>기간 : {{ data.travelData.s_date }} ~ {{ data.travelData.e_date }}</div>
          <div v-if="data.travelData.f_gender == 1">성별 : 남성만</div>
          <div v-else-if="data.travelData.f_gender == 2">성별 : 여성만</div>
          <div v-else>성별 : 상관없음</div>
          <div v-if="data.travelData.f_age == 1">연령 : 20대</div>
          <div v-if="data.travelData.f_age == 2">연령 : 30대</div>
          <div v-if="data.travelData.f_age == 3">연령 : 40대</div>
          <div v-if="data.travelData.f_age == 4">연령 : 50대</div>
          <div v-if="data.travelData.f_age == 5">연령 : 20대~30대</div>
          <div v-if="data.travelData.f_age == 6">연령 : 30대~40대</div>
          <div v-if="data.travelData.f_age == 7">연령 : 40대~50대</div>
          <div>인원 : 최대 {{ data.travelData.f_people }} 명</div>
          <div>비용 : 1인 {{ data.travelData.f_price }} 원</div>
        </div>
      </div>
      <br>
      <hr>
      <!-- 디테일 섹션2 - 호스트 정보-->
      <div>
        <div class="title-host">호스트 정보</div>
        <div class="section-host">
          <div>
            <img class="host-img" :src="`/static/img/profile/${data.hostUser.iuser}/${data.hostUser.profile_img}`"
              onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';" alt="프로필사진"
              @click="goMypage(data.hostUser.iuser)" id="profileImg">
          </div>
          <div class="section-host-ctnt">
            <div @click="goMypage(data.hostUser.iuser)">닉네임 : {{ data.hostUser.nick }}</div>
            <div @click="goMypage(data.hostUser.iuser)">소개글 : {{ data.hostUser.cmt }}</div>
          </div>
        </div>
      </div>
      <hr>
      <button type="button" @click="goToChat" v-if="isChat">채팅</button>
      <!-- 디테일 섹션3 - 상세 정보-->
      <div class="title-schedule">여행 일정</div>
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
            <div v-if="dayObj.day == item.day" class="accordion-body container-ctnt">
              <img class="detail-img container-ctnt-img" :src="`/static/img/travel/${item.itravel}/detail/${item.img}`">
              <span class="container-ctnt-txt">{{ item.ctnt }}</span>
            </div>
          </div>
        </div>
      </div>


      <div><input class="travel-fav-btn" type="button" value="찜하기" @click="insTravelFav"></div>
      <div>
        <div v-if="isJoin">
          <input class="submit-btn" type="submit" value="취소하기" @click="deletestate()">
        </div>
        <div v-else>
          <input class="submit-btn" type="submit" value="신청하기" @click="instate()">
        </div>
      </div>
      <button class="top-btn" @click="top">Top</button>
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
    top() {
      window.scrollTo(0, 0);
    },
    goMypage(iuserNum) {
      this.$store.state.feedIuser = iuserNum;
      this.$router.push({ name: 'mypage' });
      window.scrollTo(0, 0)
    },
    goToChat() {
      this.$router.push({ name: 'chat', query: {itravel: this.itravel}});
    },
    async getDetail() {
      this.itravel = this.$store.state.itravel; // store/index.js에서 itravel 가져옴
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
    async insTravelFav() {
      const loginIuser = this.$store.state.user.iuser;
      const res = await this.$post(`/travel/travelFav/${loginIuser}/${this.itravel}`, {});
      if (res.result === 1) {
        this.$swal.fire('찜 완료!', '', 'success');
      }
    },
    async instate() {                  // 컨트롤러이름 // 함수 메소드 // 필요한 값
      const instate = await this.$post(`/user/travelState/${this.loginIuser}/${this.itravel}`, {});
      if (instate.result === 1) {
        this.$swal.fire('신청 되었습니다.', '', 'success')
          .then(async result => {
            if (result.isConfirmed) {
              this.isJoin = true;
            }
          });
      } else {
        this.$swal.fire('신청할 수 없습니다.', '', 'error');
      }
    },
    async deletestate() {
      const deletestate = await this.$delete(`/user/travelState/${this.loginIuser}/${this.itravel}`, {});
      if (deletestate.result === 1) {
        this.$swal.fire('신청 취소되었습니다.', '', 'success')
          .then(async result => {
            if (result.isConfirmed) {
              this.isJoin = false;
            }
          });
      } else {
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
  color: var(--maincolor);
  width: 70%;
}

/* 디테일 섹션1 - 간단 정보(필터) */
.section-container-filter {
  display: flex;
  justify-content: center;
}

.detail-main-img {
  max-width: 40vw;
  max-height: 50vh;
}

.section-item-filter{
  display: flex;
  flex-direction: column;
  text-align: left;
  margin: 30px;
}

.title-filter {
  font-size: 1.5rem;
  color: var(--mainDark);
}

/* 디테일 섹션2 - 호스트 정보 */
.title-host,
.title-schedule {
  color: #fff;
  background-color: var(--maincolor);
  padding: 20px;
}
.host-img {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 50%;
}
.section-host {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* 디테일 섹션3 - 상세 정보 */
.detail-img {
  max-width: 20vw;
}

.container-ctnt {
  display: flex;
  background-color: #fff;
  border-bottom: 1px solid var(--maincolor);
}

.container-ctnt-img {
  padding: 20px;
}

.container-ctnt-txt {
  padding: 20px;
}

.accordion-item {
  border: 1px solid #fff;
}

.accordion-button {
  background-color: white;
  color: var(--maincolor);
  border: 1px solid var(--maincolor);
}

.accordion-button:not(.collapsed) {
  background-color: #fff;
  box-shadow: inset 0 -1px 0 rgba(255, 0, 0, 0.13);
}

/* fixed1 - 신청하기*/
.submit-btn {
  position: fixed;
  bottom: 111px;
  right: 220px;
  width: 80px;
  height: 80px;

  border-radius: 50%;
  border: 0px;
  background-color: var(--maincolor);
  color: white;
  font-weight: bold;
  box-shadow: 0 8px 8 #285d92;
}

.submit-btn:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 #2d7ac2;
}

/* fixed2 - 찜하기*/
.travel-fav-btn {
  position: fixed;
  bottom: 222px;
  right: 220px;
  width: 80px;
  height: 80px;

  border-radius: 50%;
  border: 0px;
  background-color: var(--maincolor);
  color: white;
  font-weight: bold;
  box-shadow: 0 8px 8 #285d92;
}

.travel-fav-btn:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 #2d7ac2;
}

/* fixed3 - Top*/
.top-btn {
  position: fixed;
  bottom: 333px;
  right: 220px;
  width: 80px;
  height: 80px;

  border-radius: 50%;
  border: 0px;
  background-color: var(--maincolor);
  color: white;
  font-weight: bold;
  box-shadow: 0 8px 8 #285d92;
}

.top-btn:active {
  transform: translateY(4px);
  box-shadow: 0 4px 0 #2d7ac2;
}
</style>
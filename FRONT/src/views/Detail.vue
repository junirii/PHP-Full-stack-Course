<template>
  <div class="detail">
    <div class="container">
      <h1 class="bolder" style="color: var(--maincolor); padding: 25px;">여행 상세 정보</h1>
      <!-- 디테일 섹션1 - 간단 정보(필터)-->
      <div class="section-container-filter">
        <div><img class="detail-main-img"
            :src="`/static/img/travel/${data.travelData.itravel}/main/${data.travelData.main_img}`"></div>
        <div class="section-item-filter">
          <div class="title-filter"> {{ data.travelData.title }} </div><br><br>
          <div class="btns">
            <button class="edit-del-btn" v-if="loginIuser === data.hostUser.iuser" type="button" @click="mod()">수정</button>
            <button class="edit-del-btn" v-if="loginIuser === data.hostUser.iuser" type="button" @click="del()">삭제</button>
          </div>
          <div class="info-list">
            <div v-if="!(data.travelData.location_nm)">지역 | {{ data.travelData.area_nm }}</div>
            <div v-else>지역 | {{ data.travelData.area_nm }} / {{ data.travelData.location_nm }}</div>
            <div>기간 | {{ data.travelData.s_date }} ~ {{ data.travelData.e_date }}</div>
            <div v-if="data.travelData.f_gender == 1">성별 | 남성만</div>
            <div v-else-if="data.travelData.f_gender == 2">성별 | 여성만</div>
            <div v-else>성별 | 상관없음</div>
            <div v-if="data.travelData.f_age == 1">연령 | 20대</div>
            <div v-if="data.travelData.f_age == 2">연령 | 30대</div>
            <div v-if="data.travelData.f_age == 3">연령 | 40대</div>
            <div v-if="data.travelData.f_age == 4">연령 | 50대</div>
            <div v-if="data.travelData.f_age == 5">연령 | 20대~30대</div>
            <div v-if="data.travelData.f_age == 6">연령 | 30대~40대</div>
            <div v-if="data.travelData.f_age == 7">연령 | 40대~50대</div>
            <div>인원 | {{ data.joinPeople.numberOfPeople+1 }} / {{ data.travelData.f_people }} 명</div>
            <div>비용 | 1인 {{ data.travelData.f_price.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") }} 원</div>
          </div>
        </div>
      </div>
      <br>

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
            <div class="section-host-ctnt-nick" @click="goMypage(data.hostUser.iuser)">닉네임 : {{ data.hostUser.nick }}</div>
            <div @click="goMypage(data.hostUser.iuser)">소개글 : {{ data.hostUser.cmt }}</div>
          </div>
        </div>
      </div>

      <!-- 디테일 섹션3 - 상세 정보-->
      <div class="title-schedule">여행 일정</div>
      <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item" :key="idx" v-for="(dayObj, idx) in data.day">
          <h2 class="accordion-header" id="panelsStayOpen-headingOne">
            <button class="accordion-button bolder" type="button" data-bs-toggle="collapse"
              :data-bs-target="`#panelsStayOpen-collapseOne${idx}`" aria-expanded="true"
              aria-controls="panelsStayOpen-collapseOne">
              DAY {{ dayObj.day }}
            </button>
          </h2>
          <div :id="`panelsStayOpen-collapseOne${idx}`" class="accordion-collapse collapse show underline container-box"
            aria-labelledby="panelsStayOpen-headingOne" :key="index" v-for="(item, index) in data.ctnt">
            <div v-if="dayObj.day == item.day" class="accordion-body container-ctnt">
              <div class="ctnt-box">
                <img class="container-ctnt-img" :src="`/static/img/travel/${item.itravel}/detail/${item.img}`">
              </div>
              <span class="container-ctnt-txt">{{ item.ctnt }}</span>
            </div>
          </div>
        </div>
      </div>

    <div>
      <input v-if="!isLike" class="travel-fav-btn" type="button" value="찜하기" @click="insTravelFav">
      <input v-if="isLike" class="travel-fav-btn" type="button" value="찜취소" @click="delTravelFav">
    </div>
      <div>
        <div v-if="isJoin">
          <input class="submit-btn" type="submit" value="취소하기" @click="deletestate()">
        </div>
        <div v-if="isJoin && isconfirm === 1">
          <input class="submit-btn" type="submit" value="나가기" @click="deletestate(); exitChatRoom();">
        </div>
        <div v-if="!isJoin && loginIuser !== data.hostUser.iuser">
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
      isconfirm: null,
      isJoin: false,
      isLike: false,
      joinPeople: 0,
      travelfav: [],
    }
  },
  methods: {
    async exitChatRoom(){
      const res = await this.$delete(`/chat/exitChatRoom/${this.itravel}/${this.loginIuser}`, {});
      if(res.result == 1){
        const res = await this.$post('/chat/insChatMsg', {
            itravel: this.itravel,
            iuser: 0,
            msg: `${this.$store.state.user.nick}님이 퇴장하셨습니다.`
        });
      }
    },
    mod(){
      this.$store.state.mod.travelData = this.data.travelData;
      this.$store.state.mod.ctnt = this.data.ctnt;
      this.$router.push({ name: 'create', params: {mod: 1}});
    },
    top() {
      window.scrollTo(0, 0);
    },
    goMypage(iuserNum) {
      this.$store.state.feedIuser = iuserNum;
      this.$router.push({ name: 'mypage', query: {
        feedIuser: iuserNum
      }});
      window.scrollTo(0, 0)
    },
    async getDetail() {
      this.itravel = this.$store.state.itravel; // store/index.js에서 itravel 가져옴
      this.loginIuser = this.$store.state.user.iuser;
      const res = await this.$get(`/travel/detail/${this.itravel}`, {}); // controllers / method / 가져온itravel
      const res2 = await this.$get(`/travel/travelState/${this.loginIuser}/${this.itravel}`, {});
      this.data = res.result;
      console.log(this.data);
      console.log('itravel ' + this.itravel);
      console.log('loginuser ' + this.loginIuser);
      console.log('hostiuser ' + this.data.hostUser.iuser);
      if(res2.result){
        this.isconfirm = res2.result.isconfirm;
        this.isJoin = true;
      }
      console.log(this.isJoin);
      console.log(this.isconfirm);

      // if (this.data.travelData.f_gender == 1) {
      //   this.data.travelData.f_gender = '남성';
      // } else if (this.data.travelData.f_gender == 2) {
      //   this.data.travelData.f_gender = '여성';
      // } else {
      //   this.data.travelData.f_gender = '혼성';
      // }
    },
    async favTravelState() {
      this.itravel = this.$store.state.itravel;
      const loginIuser = this.$store.state.user.iuser;
      const res = await this.$get(`/travel/travelFav/${loginIuser}`, {});
      console.log(this.isLike);
      console.log(res);
      this.travelfav = res.result;
      console.log(this.travelfav);
      console.log(this.itravel);
      console.log('isLike:'+this.isLike)
      this.isLike = false;
      const Ifav = this.travelfav.some( X=> {
        return X.itravel === this.itravel
      });
      this.isLike = Ifav;
    },
    async insTravelFav() {
      const loginIuser = this.$store.state.user.iuser;
      const res = await this.$post(`/travel/travelFav/${loginIuser}/${this.itravel}`, {});
      if (res.result === 1) {
        this.$swal.fire('찜 완료!', '', 'success')
        .then(async result => {
            if (result.isConfirmed) {
              this.isLike = true;
            }
          });
      } else {
        this.$swal.fire('찜을 할 수 없습니다.', '', 'error');
      }
    },
    async delTravelFav() {
      const loginIuser = this.$store.state.user.iuser;
      const res = await this.$delete(`/travel/travelFav/${loginIuser}/${this.itravel}`, {});
      if (res.result === 1) {
        this.$swal.fire('찜 취소!', '', 'success')
        .then(async result => {
            if (result.isConfirmed) {
              this.isLike = false;
            }
          });
      } else {
        this.$swal.fire('찜 취소를 할 수 없습니다..', '', 'error');
      }
    },
    async instate() {                  // 컨트롤러이름 // 함수 메소드 // 필요한 값
      const instate = await this.$post(`/travel/travelState/${this.loginIuser}/${this.itravel}`, {});
      if (instate.result === 1) {
        console.log(instate);
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
      const deletestate = await this.$delete(`/travel/travelState/${this.loginIuser}/${this.itravel}`, {});
      if (deletestate.result === 1) {
        console.log(deletestate);
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
    async del() {
      const delTravel = await this.$delete(`/travel/del/${this.itravel}/${this.loginIuser}`, {});
      console.log(delTravel);
      if(delTravel.result === 1) {
        this.$swal.fire('삭제완료.', '', 'success')
        .then(async result => {
          console.log(result);
          this.$router.push({ name: 'list' });
        })
      }
    }
  },
  created() {
    this.getDetail();
    this.favTravelState();
  }
}
</script>

<style scoped>
.detail {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.container {
  color: var(--maincolor);
  width: 60%;
}
.btns {
  display: flex;
  flex-direction: row;

}
.edit-del-btn {
  margin-bottom: 50px;
  display: inline-block;
  text-decoration: underline;
  text-underline-position: under;
  background: none;
  font-weight: bolder;
  color: var(--mainOrange);
  border: 0;
  margin-right: 10px;
}

.edit-del-btn:active {
  cursor: pointer;
}

/* 디테일 섹션1 - 간단 정보(필터) */
.section-container-filter {
  margin-top: 20px;
  display: flex;
  justify-content: center;
}
.detail-main-img {
  max-width: 30vw;
  max-height: 40vh;
}
.section-item-filter{
  display: flex;
  flex-direction: column;
  text-align: left;
  margin-left: 30px;
  justify-content: space-between;
}
.title-filter {
  font-size: 1.5rem;
  color: var(--maincolor);
}
.info-list {
  line-height: 30px;
}
/* 디테일 섹션2 - 호스트 정보 */
.title-host, .title-schedule {
  color: #fff;
  background-color: var(--maincolor);
  padding: 20px;
  font-size: 20px;
}
.host-img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
  cursor: pointer;
  margin: 20px;
}
.section-host-ctnt-nick{
  cursor: pointer;
  text-align: left;
}
.section-host {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* 디테일 섹션3 - 상세 정보 */
.container-ctnt {
  display: flex;
}
.container-ctnt-img {
  margin: 20px;
  width: 400px;
  height: 300px;
  object-fit: cover;
}
.container-ctnt-txt {
  padding: 20px;
  text-align: left;
  line-height: 30px;
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
  /* box-shadow: inset 0 -1px 0 rgba(255, 0, 0, 0.13); */
}
/* fixed1 - 신청하기*/
.submit-btn {
  position: fixed;
  bottom: 130px;
  right: 250px;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 0px;
  background-color: var(--mainOrange);
  color: white;
  font-weight: bold;
}
.submit-btn:hover {
  /* transform: translateY(4px); */
  border: 2px solid var(--mainOrange);
  background-color: #fff;
  color: var(--mainOrange);
}
/* fixed2 - 찜하기*/
.travel-fav-btn {
  position: fixed;
  bottom: 240px;
  right: 250px;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 0px;
  background-color: var(--mainOrange);
  color: white;
  font-weight: bold;
}
.travel-fav-btn:hover {
  /* transform: translateY(4px); */
  border: 2px solid var(--mainOrange);
  background-color: #fff;
  color: var(--mainOrange);
}
/* fixed3 - Top*/
.top-btn {
  position: fixed;
  bottom: 350px;
  right: 250px;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 0px;
  background-color: var(--mainOrange);
  color: white;
  font-weight: bold;
}
.top-btn:active {
  background-color: #fff;
  border: 2px solid var(--mainOrange);
  color: var(--mainOrange);
}
</style>
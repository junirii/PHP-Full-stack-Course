<template>
  <div class="my-page">
    <div class="container">
      <h1 class="my-page-title bolder">{{ selUser.nick }}님의 페이지</h1>
      <!-- 마이페이지 섹션1 - 프로필 -->
      <div class="mypage-profile">
        <div class="mypage-profile-img">
          <img class="profile-img" :src="`/static/img/profile/${selUser.iuser}/${selUser.profile_img}`"
            onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';" alt="프로필사진"
            @click="showModal" id="profile-img">
        </div>
        <div class="mypage-profile-txt">
          <div>상태메세지 : {{ selUser.cmt }}</div>
          <div :key="item.igrade" v-for="item in myPageGrade">
            <div>평점 : {{ item.avgOfGrade }}점</div>
          </div>
          <!--이 유저의 평균평점 = 이 유저가 호스팅한 모든 여행의 평점 합계의 평균..... 함수를 하나 빼야하는건가.....?
          ROUND(AVG(A.grade),1) AS avgOfGrade -->
          <div v-if="feedIuser == loginIuser">
            <router-link :to="{ path: '/MyAccount' }">
              <div><i class="fa-solid fa-pencil fa"></i>프로필수정</div>
            </router-link>
          </div>
        </div>
      </div>
      <br>
      <!-- <ProfileImgModal :show="modalShow" @close="hiddenModal" v-on:update="getUserData" v-on:defaultImg="setDefaultImg" /> -->
      <Test :show="modalShow" @close="hiddenModal" v-on:update="getUserData" v-on:defaultImg="setDefaultImg" />
      <!-- 마이페이지 섹션2 - 신청 여행(신청중, 신청수락), 찜한 여행, 호스팅한 여행 , 참여한 여행 -->
      <div v-if="feedIuser == loginIuser">
        <div class="title">신청한 여행 현황</div> <!-- 신청중, 신청수락 여행 슬라이드로 띄우기-->
        <div>
          <div>
            <div>신청중</div>
            <div v-if="preTravel.length < 1">신청한 여행이 없습니다.</div>
            <Carousel>
              <Slide v-for="item in preTravel" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
                <img class="carousel__item" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`">
                <div class="travel-nm">{{ item.title }}</div>
              </Slide>
              <template #addons>
                <Navigation v-if="preTravel.length > 1"/>
              </template>
            </Carousel>
          </div>
          <hr>
          <div>
            <div>신청완료</div>
            <div v-if="ingTravel.length < 1">신청완료된 여행이 없습니다.</div>
            <Carousel>
              <Slide v-for="item in ingTravel" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
                <img class="carousel__item" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`">
                <div class="travel-nm">{{ item.title }}</div>
              </Slide>
              <template #addons>
                <Navigation v-if="ingTravel.length > 1"/>
              </template>
            </Carousel>
          </div>
        </div>
      </div>
      <br>

      <div v-if="feedIuser == loginIuser">
        <div class="title">찜한 여행</div>
        <div v-if="myPageTravelFav.length < 1">찜한 여행이 없습니다.</div>
          <Carousel>
            <Slide v-for="item in myPageTravelFav" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
              <img class="carousel__item" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`">
              <div class="travel-nm">{{ item.title }}</div>
            </Slide>
            <template #addons>
              <Navigation v-if="myPageTravelFav.length > 1"/>
            </template>
          </Carousel>
      </div>
      <br>

      <div>
        <div class="title">호스팅한 여행</div>
        <div v-if="myPageHost.length < 1">호스팅한 여행이 없습니다.</div>
          <Carousel class="carousel">
            <Slide v-for="item in myPageHost" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
              <img class="carousel__item" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`">
              <div class="travel-nm">{{ item.title }}</div>
            </Slide>
            <template #addons>
              <Navigation v-if="myPageHost.length > 1"/>
            </template>
          </Carousel>
      </div>
      <br>

      <div>
        <div class="title">참여한 여행</div>
        <div v-if="postTravel.length < 1">참여한 여행이 없습니다.</div>
          <Carousel class="carousel">
              <Slide v-for="item in postTravel" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
                <div v-if="item.isconfirm == 2">
                  <img class="carousel__item" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`">
                  <div class="travel-nm">{{ item.title }}</div>
                </div>
              </Slide>
              <template #addons>
                <Navigation v-if="postTravel.length > 1"/>
              </template>
          </Carousel>
      </div>
      <br>

      <!-- 마이페이지 섹션3 - 리뷰-->

      <div>
        <div class="title"><i class="fa-solid fa-comment p-15"></i>리뷰</div>
        <div :key="item.icmt" v-for="item in myPageCmt">
          <div class="section-list">
            <span>
              <img class="reviewer-profile-img" :src="`/static/img/profile/${item.iuser}/${item.profile_img}`"
                onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';" alt="프로필사진"
                @click="goToMyPageFromReview(item.iuser)">
            </span>
            <span class="section-list-nick" @click="goToMyPageFromReview(item.iuser)">{{ item.nick }}</span>
            <span class="section-list-cmt">{{ item.cmt }}</span>
            <span class="section-list-reg-dt">{{ item.reg_dt }}</span>
            <span v-if="item.grade == 1" class="section-list-grade"> ★(1)</span>
            <span v-if="item.grade == 2" class="section-list-grade"> ★★(2)</span>
            <span v-if="item.grade == 3" class="section-list-grade"> ★★★(3)</span>
            <span v-if="item.grade == 4" class="section-list-grade"> ★★★★(4)</span>
            <span v-if="item.grade == 5" class="section-list-grade"> ★★★★★(5)</span>
            <span class="section-list-title">참여여행: [{{ item.title }}]</span>
          </div>
        </div>

        <div v-if="this.myPageCmt.length < 1">등록된 리뷰가 없습니다.</div>
        <div v-if="this.loginIuser !== selUser.iuser">
          <select class="section-select" v-model="selectedTravel">
            <option value="" selected>참여한 여행(selected 안됨)</option>
            <option :value="item.itravel" :key="item.itravel" v-for="item in guestTravel">{{ item.title }}</option>
          </select>
          <input class="section-comment" v-model="cmt" type="textarea" @keyup="enter($event)">
          <select class="section-grade" v-model="grade" type="select" @keyup="enter($event)">
            <option value="1" selected>★★★★★(5)점</option>
            <option value="2">★★★★(4)점</option>
            <option value="3">★★★(3)점</option>
            <option value="4">★★(2)점</option>
            <option value="5">★(1)점</option>
          </select>
          <input class="section-submit" type="submit" value="등록" @click="insCmt">
        </div>
      </div>
    </div> <!-- container 닫기 -->
  </div>
</template>

<script>
import ProfileImgModal from '/src/components/common/ProfileImgModal.vue';
import Test from '/src/components/common/test.vue';
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';

export default {
  data() {
    return {
      data: [],
      myPageTravelFav: [],
      myPageHost: [],
      myPageTravelState: [],
      preTravel: [],
      ingTravel: [],
      postTravel: [],
      myPageCmt: [],
      selUser: {},
      guestTravel: [],
      selectedTravel: null,
      feedIuser: 0,
      loginIuser: 0,
      cmt: '',
      selUserFav: [],
      modalShow: false,
      myPageGrade: [],
    }
  },
  components: {
    Test,
    ProfileImgModal,
    Carousel,
    Slide,
    Pagination,
    Navigation,
},
  methods: {
    setDefaultImg() {
      document.querySelector('#profile-img').src = '/static/img/profile/common/defaultImg.webp';
    },
    hiddenModal() {
      this.modalShow = false;
    },
    showModal() {
      if (this.feedIuser == this.loginIuser) {
        this.modalShow = true;
      }
    },
    async getMyPage() { // mypage 받아오기
      console.log(this.$store.state.user);
      this.feedIuser = this.$route.query.feedIuser;
      this.loginIuser = this.$store.state.user.iuser;
      console.log('feedIuser : ' + this.feedIuser);
      console.log('loginIuser : ' + this.loginIuser);

      this.data = await this.$get(`/user/myPage/${this.feedIuser}/${this.loginIuser}`, {}); // controllers / method
      console.log(this.data);
      this.myPageTravelFav = this.data.result.myPageTravelFav;
      this.myPageHost = this.data.result.myPageHost;
      this.myPageTravelState = this.data.result.myPageTravelState;
      this.selUserFav = this.data.result.selUserFav;
      this.myPageTravelState.forEach(item => {
        switch (item.isconfirm) {
          case 0:
            this.preTravel.push(item);
            break;
          case 1:
            this.ingTravel.push(item);
            break;
          case 2:
            this.postTravel.push(item);
            break;
        }
      });
      this.guestTravel = this.data.result.guestTravel;
      this.selUserFav = this.data.result.selUserFav;  // 인기도
      console.log(this.selUserFav[0]);
    },
    async getUserData() {
      console.log(this.feedIuser);
      const res = await this.$get(`/user/selUser/${this.feedIuser}`, {});
      console.log(res);
      this.selUser = res.result;
    },
    async goToDetailFromMyPage(itravelNum) { // 클릭시 여행게시물로 이동
      this.$store.state.itravel = itravelNum;
      this.$router.push({ name: 'detail' });
    },
    async goToMyPageFromReview(iuserNum) { // 클릭시 여행게시물로 이동
      this.$store.state.iuser = iuserNum;
      this.$router.push({ name: 'mypage', query: { feedIuser: iuserNum } });
    },
    async insCmt() { // 댓글삽입기능
      const res = await this.$post('/user/insCmt', {
        itravel: this.selectedTravel,
        guest_iuser: this.loginIuser,
        cmt: this.cmt
      });
      console.log(res.result);
      if (res.result === 1) {
        this.selectedTravel = 0;
        this.cmt = '';
        this.getCmt();
      }
    },
    async getCmt() {
      const res = await this.$get(`/user/getCmt/${this.feedIuser}`, {});
      console.log(res.result)
      if (res) {
        this.myPageCmt = res.result;
      }
    },
    enter(e) {
      if (e.key === 'Enter') {
        this.insCmt();
      }
    },
      async getGrade() {
      const res = await this.$get(`/user/getGrade/${this.feedIuser}`, {});
      console.log(res.result)
      if (res) {
        this.myPageGrade = res.result;
      }
    },
  },
  created() {
    this.getMyPage();
    this.getUserData();
    this.getCmt();
    this.getGrade();
  }
}

</script>

<style scoped>
.carousel { cursor: pointer; }
.carousel__item {
  min-height: 200px;
  width: 200px;
  background-color: var(--vc-clr-primary);
  color:  var(--vc-clr-white);
  font-size: 20px;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel__slide {
  padding: 10px;
}

.carousel__prev {
  left: 150px;
  box-sizing: content-box;
  border: 5px solid white;
}
.carousel__next {
  box-sizing: content-box;
  border: 5px solid white;
  right: 150px;
}
.my-page {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.container {
  color: var(--maincolor);
  width: 60%;
}
.my-page-title {
  color: var(--maincolor);
  padding-bottom: 25px;
}

/* 마이페이지 섹션1 - 프로필 */
.mypage-profile {
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  padding-bottom: 20px;
}

.mypage-profile .mypage-profile-txt {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.carousel { 
  cursor: pointer;
}
.carousel__item {
  min-height: 200px;
  width: 300px;
  object-fit: cover;
  background-color: var(--vc-clr-primary);
  color: var(--vc-clr-white);
  font-size: 20px;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.travel-nm {
  padding-left: 20px;
}
.carousel__slide {
  padding: 10px;
}
.carousel__prev {
  background-color: var(--maincolor);
  left: 150px;
  box-sizing: content-box;
  border: 5px solid white;
}
.carousel__next {
  box-sizing: content-box;
  border: 5px solid white;
  right: 150px;
  background-color: var(--maincolor);
}

.title {
  background-color: var(--maincolor);
  color: #fff;
  height: 5vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.3rem;
  margin-bottom: 20px;
}
.travel-state {
  color: var(--maincolor);
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.3rem;
  text-decoration: underline;
  text-underline-position: under;
}
.ctnt {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  border-bottom: 1px solid var(--maincolor);
}
.profile-img {
  width: 250px;
  height: 250px;
  object-fit: cover;
  border-radius: 50%;
  cursor: pointer;
}

/* 마이페이지 섹션3 - 리뷰 */
.section-list {
  color: var(--maincolor);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 5vh;
}

.section-list-nick {
  width: 8vw;
  cursor: pointer;
  text-align: left;
}

.section-list-cmt {
  width: 22vw;
  text-align: left;
}

.section-list-reg-dt {
  width: 10vw;
  text-align: left;
}

.section-list-grade {
  width: 7vw;
  text-align: left;
}
.section-list-title {
  width: 10vw;
}
.reviewer-profile-img {
  width: 30px;
  height: 30px;
  object-fit: cover;
  border-radius: 50%;
  cursor: pointer;
}
.section-select {
  height: 3vh;
  border: 1px solid var(--maincolor);
  margin: 3px;

}
.section-comment {
  width: 10vw;
  height: 3vh;
  border: 1px solid var(--maincolor);
  border-radius: 0%;
  margin: 3px;
}
.section-grade {
  width: 5vw;
  height: 3vh;
  margin: 3px;
  border: 1px solid var(--maincolor);
  border-radius: 0%;
}
.section-submit {
  background-color: var(--maincolor);
  color: #fff;
  border: 1px solid var(--maincolor);
  height: 3vh;
  margin: 3px;
}
</style>

<!-- console.log(this.$store.state.user); // 로그인한 유저정보가 담겨져 있음 -->
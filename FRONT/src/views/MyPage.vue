<template>
  <div class="location">
    <div class="container">
      <div>{{ selUser.nick }}님의 게시판</div>
      <!-- 마이페이지 섹션1 - 프로필 -->
      <div class="mypage-profile">
        <div class="mypage-profile-img">
          <img class="profile-img" :src="`/static/img/profile/${selUser.iuser}/${selUser.profile_img}`"
            onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';" alt="프로필사진"
            @click="showModal" id="profile-img">
        </div>
        <div class="mypage-profile-txt">
          <div>닉네임 : {{ selUser.nick }}</div>
          <div>상태메세지 : {{ selUser.cmt }}</div>
          <div>DM<i class="fa-regular fa-paper-plane"></i></div>
          <div>인기도 : {{ favCount }}<i class="fa-solid fa-heart userFav" @click="usergood()"></i></div>
          <div v-if="feedIuser == loginIuser">
            <router-link :to="{ path: '/MyAccount' }">
              <div><i class="fa-solid fa-pencil fa"></i>프로필수정</div>
            </router-link>
          </div>
        </div>
      </div>
      <br>
      <!-- 마이페이지 섹션2 - 신청 여행(신청중, 신청수락), 찜한 여행, 호스팅한 여행 , 참여한 여행 -->

      <div v-if="feedIuser == loginIuser">
        <div class="state-title">신청 여행</div> <!-- 신청중, 신청수락 여행 슬라이드로 띄우기-->
        <div>
          <div>
            <div>신청중</div>
            <div v-for="item in preTravel" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
              <img class="my-page-img" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" alt="이미지">
              <div>{{ item.title }}</div>
            </div>
          </div>

          <div>
            <div>신청완료</div>
            <div v-for="item in ingTravel" :key="item.itravel" @click="goToDetailFromMyPage(item.itravel)">
              <img class="my-page-img" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" alt="이미지">
              <div>{{ item.title }}</div>
            </div>
          </div>
        </div>
      </div>
      <br>

      <div v-if="feedIuser == loginIuser">
        <div class="title">찜한 여행</div>
        <div class="ctnt" :key="item.itravel" v-for="item in myPageTravelFav"
          @click="goToDetailFromMyPage(item.itravel)">
          <img class="my-page-img" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" alt="이미지">
          <span class="ctnt-title">{{ item.title }}</span>
        </div>
      </div>
      <br>

      <div>
        <div class="title">호스팅한 여행</div>
        <div class="ctnt" :key="item.itravel" v-for="item in myPageHost" @click="goToDetailFromMyPage(item.itravel)">
          <img class="my-page-img" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" alt="이미지">
          <span class="ctnt-title">{{ item.title }}</span>
        </div>
      </div>
      <br>

      <div>
        <div class="title">참여한 여행</div>
        <div class="ctnt" :key="item.itravel" v-for="item in postTravel"
          @click="goToDetailFromMyPage(item.itravel)">
          <div v-if="item.isconfirm == 2">
            <img class="my-page-img" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" alt="이미지">
            <span class="ctnt-title">{{ item.title }}</span>
          </div>
        </div>
      </div>
      <br>

      <!-- 마이페이지 섹션3 - 리뷰-->

      <div>
        <div class="title"><i class="fa-solid fa-comment"></i>리뷰</div>
        <div :key="item.icmt" v-for="item in myPageCmt">
          <span class="section-list">
            <span>
            <img class="reviewr-profile-img" :src="`/static/img/profile/${this.$store.state.user.iuser}/${this.$store.state.user.profile_img}`"
              onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';" alt="프로필사진"
              @click="goMypage(data.hostUser.iuser)" id="profileImg">
            </span>{{ item.profile_img }}{{ item.nick }}{{ item.cmt }}{{ item.reg_dt }}by{{ item.title }}</span>
        </div>

        <div>
          <select class="section-select" v-model="selectedTravel">
            <option value="" selected>참여한 여행(selected 안됨)</option>
            <option :value="item.itravel" :key="item.itravel" v-for="item in guestTravel">{{ item.title }}</option>
          </select>
          <input class="section-comment" v-model="cmt" type="textarea" @keyup="enter($event)">
          <input class="section-submit" type="submit" value="등록" @click="insCmt">
        </div>
      </div>
    </div> <!-- container 닫기 -->
  </div>

  <ProfileImgModal :show="modalShow" @close="hiddenModal" v-on:update="getUserData" v-on:defaultImg="setDefaultImg" />
</template>

<script>
import ProfileImgModal from '/src/components/common/ProfileImgModal.vue';

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
      favCount: null, //수정 필요
      modalShow: false,
    }
  },
  components: {
    ProfileImgModal
  },
  methods: {
    async getUserData() {
      const res = await this.$get(`/user/selUser/${this.feedIuser}`, {});
      console.log(res);
      this.selUser = res.result;

    },
    setDefaultImg() {
      document.querySelector('#profile-img').src = '/static/img/profile/common/defaultImg.webp';
    },
    hiddenModal() {
      this.modalShow = false;
    },
    showModal() {
      this.modalShow = true;
      console.log(this.modalShow);
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
      this.myPageTravelState.forEach(item => {
        switch(item.isconfirm){
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
    async goToDetailFromMyPage(itravelNum) { // 클릭시 여행게시물로 이동
      this.$store.state.itravel = itravelNum;
      this.$router.push({ name: 'detail' });
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
    async usergood() {
      alert('dd');
    },
  },
  created() {
    this.getMyPage();
    this.getUserData();
    this.getCmt();
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

}
/* 마이페이지 섹션1 - 프로필 */
.mypage-profile {
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
}

.mypage-profile .mypage-profile-txt {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

/* 마이페이지 섹션2 - 신청 여행(신청중, 신청수락), 찜한 여행, 호스팅한 여행 , 참여한 여행 */
.state-title {
  background-color: var(--maincolor);
  color: #fff;
  height: 5vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.state-title:hover {
  background-color: rgb(207, 207, 207);
}

.title {
  background-color: var(--maincolor);
  color: #fff;
  height: 5vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.title:hover {
  background-color: rgb(207, 207, 207);
}

.ctnt {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  border-bottom: 1px solid var(--maincolor);
}

.ctnt-title {
  display: flex;
  align-self: center;
}

.userFav {
  cursor: pointer;
}

.my-page-img {
  max-width: 20vw;
}

.profile-img {
  width: 300px;
  height: 300px;
  object-fit: cover;
  border-radius: 50%;
}

/* 마이페이지 섹션3 - 리뷰 */
.section-list{
  color: var(--maincolor);
}
.reviewr-profile-img{
  border-radius: 50%;
}
.section-select{
  height: 3vh;
  border: 1px solid var(--maincolor);
  margin: 3px;

}
.section-comment{
  width: 20vw;
  height: 3vh;
  border: 1px solid var(--maincolor);
  border-radius: 0%;
  margin: 3px;

}
.section-submit{
  background-color: var(--maincolor);
  color: #fff;
  border: 1px solid var(--maincolor);
  height: 3vh;
  margin: 3px;


}
</style>

<!-- console.log(this.$store.state.user); // 로그인한 유저정보가 담겨져 있음 -->
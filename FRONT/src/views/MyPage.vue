<template>
  <div class="location">
    <div class="container">
      <div>{{ selUser.nick }}님의 게시판</div>
      <!-- 마이페이지 섹션1 - 프로필 -->
      <div class="mypage_profile">
        <div class="mypage_profile_img">
          <img :src="`/static/img/profile/${selUser.iuser}/${selUser.profile_img}`"
           onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';"
           alt="프로필사진" @click="showModal" id="profileImg"></div>
        <div class="mypage_profile_txt">
          <div>닉네임 : {{ selUser.nick }}</div>
          <div>상태메세지 : {{ selUser.cmt }}</div>
          <div><i class="fa-regular fa-paper-plane" @click="goToChat"></i>DM</div>
          <div><i class="fa-solid fa-heart userFav" @click="usergood()"></i>{{favCount}}</div>
          <div v-if="feedIuser == loginIuser">
            <router-link :to="{ path: '/MyAccount' }">
              <div><i class="fa-solid fa-pencil fa"></i>프로필수정</div>
            </router-link>
          </div>
        </div>
      </div>
      <br>

      <div v-if="feedIuser == loginIuser">
        <div class="title">신청 여행</div>
        <div :key="item.itravel" v-for="item in userTravelState" @click="goToDetailFromMyPage(item.itravel)">
          <div v-if="item.isconfirm == 0"> 신청중
            <img class="myPageImg" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" @click="goToDetail(item.itravel)" alt="이미지">
            <span>{{ item.title }}</span>
          </div>
          <div v-if="item.isconfirm == 1"> 신청수락
            <img class="myPageImg" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" @click="goToDetail(item.itravel)" alt="이미지">
            <span>{{ item.title }}</span>
          </div>
        </div>
      </div>
      <br>
      <!-- 마이페이지 섹션2 - 찜한 여행, 호스팅한 여행 , 참여한 여행-->
      <div v-if="feedIuser == loginIuser">
        <div class="title">찜한 여행</div>
        <div :key="item.itravel" v-for="item in myPageTravelFav" @click="goToDetailFromMyPage(item.itravel)">
          <img class="myPageImg" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" @click="goToDetail(item.itravel)" alt="이미지">
          <span>{{ item.title }}</span>
        </div>
      </div>
      <br>

      <div>
        <div class="title">호스팅한 여행</div>
        <div :key="item.itravel" v-for="item in myPageHost" @click="goToDetailFromMyPage(item.itravel)">
          <img class="myPageImg" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" @click="goToDetail(item.itravel)" alt="이미지">
          <span>{{ item.title }}</span>
        </div>
      </div>
      <br>

      <div>
        <div class="title">참여한 여행</div>
        <div :key="item.itravel" v-for="item in userTravelState" @click="goToDetailFromMyPage(item.itravel)">
            <div v-if="item.isconfirm == 2">
            <img class="myPageImg" :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`" @click="goToDetail(item.itravel)" alt="이미지">
            <span>{{ item.title }}</span>
          </div>
        </div>
      </div>
      <br>

      <!-- 마이페이지 섹션3 - 리뷰-->

      <div>
        <div class="title"><i class="fa-solid fa-comment"></i>리뷰</div>
        <div :key="item.icmt" v-for="item in myPageCmt">
          <span>{{ item.title }} {{ item.cmt }} {{ item.profile_img }} {{ item.nick }} {{ item.reg_dt }} </span>
        </div>

        <div>
          <select v-model="selectedTravel">
            <option value="" selected>참여한 여행(selected 안됨)</option>
            <option :value="item.itravel" :key="item.itravel" v-for="item in guestTravel">{{ item.title }}</option>
          </select>
          <input v-model="cmt" type="textarea" @keyup="enter($event)">
          <input type="submit" value="등록" @click="insCmt">
        </div>
      </div>
    </div> <!-- container 닫기 -->
  </div>

  <ProfileImgModal 
    :show="modalShow" 
    @close="hiddenModal"
    v-on:update="getUserData"
    v-on:defaultImg="setDefaultImg" />
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
      myPageCmt: [],
      selUser: {},
      guestTravel: [],
      userTravelState: [],
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
    goToChat(){

    },
    async getUserData(){
      const res = await this.$get(`/user/selUser/${this.feedIuser}`, {});
      console.log(res);
      this.selUser = res.result;
    },
    setDefaultImg(){
      document.querySelector('#profileImg').src = '/static/img/profile/common/defaultImg.webp';
    },
    hiddenModal(){
      this.modalShow = false;
    },
    showModal(){
      this.modalShow = true;
      console.log(this.modalShow);
    },
    async getMyPage() { // mypage 받아오기
      console.log(this.$store.state.user);
      this.feedIuser = this.$store.state.feedIuser;
      this.loginIuser = this.$store.state.user.iuser;
      this.selUserFav = this.$store.state.selUserFav; // 인기도
      console.log('feedIuser : ' + this.feedIuser);
      console.log('loginIuser : ' + this.loginIuser);

      this.data = await this.$get(`/user/myPage/${this.feedIuser}/${this.loginIuser}`, {}); // controllers / method
      console.log(this.data);
      this.myPageTravelFav = this.data.result.myPageTravelFav;
      this.myPageHost = this.data.result.myPageHost;
      this.myPageTravelState = this.data.result.myPageTravelState;
      this.userTravelState = this.data.result.userTravelState;
      this.guestTravel = this.data.result.guestTravel;
      this.selUserFav = this.data.result.selUserFav;  // 인기도
      console.log(this.selUserFav[0]);
      console.log(this.userTravelState);
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

/* css 한거 아님 보기편하게 하려고 임시로 해놓은거임 구리다고 뭐라하지마세여.. */

.location {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}

.title {
  background-color: rgb(170, 170, 170);
  border: 1px solid rgb(170, 170, 170);
  border-radius: 5px;
  padding: 5px;
  margin: 5px;
  color: #fff;
}

.title :hover {
  background-color: rgb(192, 192, 192);
}

.mypage_profile {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

/* .mypage_profile .mypage_profile_img {
    display: flex;    
} */

.mypage_profile .mypage_profile_txt {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.userFav {
  cursor: pointer;
}

 .myPageImg {
  max-width: 20vw;
 }
</style>

<!-- console.log(this.$store.state.user); // 로그인한 유저정보가 담겨져 있음 -->
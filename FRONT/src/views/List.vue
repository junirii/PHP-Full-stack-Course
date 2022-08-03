<template>
  <main class="list mt-3">
    <div class="container">   
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6" style="padding: 25px;"
            :key="item.itravel" v-for="item in list">
            <div class="card" style="width: 16rem; height: 20rem; padding: 25px;">
              <div class="hearticon">
                <i class="fa-solid fa-heart fa-2x" v-if="heartColor($event, item.itravel)" style="color: red;" @click="good($event, item.itravel)"></i>
                <i class="fa-regular fa-heart fa-2x" v-if="!heartColor($event, item.itravel)" @click="good($event, item.itravel)"></i>
                <!-- <div class="card-img-top" @click="goToDetail(item.itravel)">{{item.main_img}}</div> -->
                <img src="https://d30y0swoxkbnsm.cloudfront.net/community/20200324/748d6a3d-648e-426b-a705-f47f654b6d4a/%EC%B9%B4%EB%AC%B4%EC%9D%B4.jpg" 
                @click="goToDetail(item.itravel)"
                  class="card-img-top" style="width: 16rem; height: 16rem;"
                  alt="이미지">
              </div>
            <div class="card-body">
              <h5 class="card-title" @click="goToDetail(item.itravel)">{{ item.title }}</h5>
              <p class="card-text">
                <span class="badge bg-dark text-white me-1 pointer" @click="goToMyPage(item.iuser)">작성자:{{ item.nick }}</span>
                <span class="badge bg-dark text-white me-1">지역: {{ item.area }}/{{ item.location }}</span>
                <!-- <span class="badge bg-dark text-white me-1">location:{{ item.location }}</span> -->
              </p>
              <small class="text-dark">{{ item.s_date }} ~ {{ item.e_date }}</small>
            </div>
          </div>
        </div>         
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return{
    list: [],
    travelFavList: [],
    favItravelList: [],
    iuser: null
    }
  },
  methods: {
    async travelList() {
      this.list = await this.$get('/travel/travelList');
    },
    async goToDetail(itravelNum) {
      this.$store.state.itravel = itravelNum;
      this.$router.push({name: 'detail'});
    },
    async favItravel() {
      this.iuser = this.$store.state.user.iuser;
      this.travelFavList = await this.$get(`/travel/travelFav/${this.iuser}`, {});
      this.travelFavList.result.forEach(item => {
        this.favItravelList.push(item.itravel);
      });
    },
    heartColor(event, itravel) {
      if(this.favItravelList.includes(itravel)){
        return true;
      }else{
        return false;
      }
    },
    async good(event, itravel) {
      if(event.target.classList.contains('fa-regular')){ //검은 하트일 때
        const res = await this.$post(`/travel/travelFav/${this.iuser}/${itravel}`);
        if(res.result === 1){ // 좋아요 성공 시
          event.target.classList.remove('fa-regular');
          event.target.classList.add('fa-solid');
          event.target.style.color = "red";
        }
      }else if(event.target.classList.contains('fa-solid')){
        const res = await this.$delete(`/travel/travelFav/${this.iuser}/${itravel}`);
        if(res.result === 1){ // 좋아요 취소 성공 시
          event.target.classList.add('fa-regular');
          event.target.classList.remove('fa-solid');
          event.target.style.color = "";
        }
      }
    },
    async goToMyPage(iuserNum) {
      this.$store.state.feedIuser = iuserNum;
      this.$router.push({name: 'mypage'});
    }
  },

  created() {
    this.travelList();
    this.favItravel();
    console.log(this.$store.state.filter);
    // console.log(this.$store.state.selectedArea);
  },
}

</script>

<style>
.list { 
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.hearticon {
  position: relative;
}
i {
  position : absolute;
  right: 4px;
  top: 4px; 
  cursor: pointer;
 }
 .img {
  max-width: 150px;
 }
.pointer {
  cursor: pointer;
}

</style>
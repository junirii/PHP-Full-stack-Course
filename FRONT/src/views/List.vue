<template>
  <main class="mt-3">
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6" style="padding: 25px;"
            :key="item.iboard" v-for="item in list">
            <div class="card" style="width: 18rem;">
              <div class="hearticon">
                <i class="fa-solid fa-heart fa-2x" v-if="heartColor($event, item.iboard)" style="color: red;" @click="good($event, item.iboard)"></i>
                <i class="fa-regular fa-heart fa-2x" v-if="!heartColor($event, item.iboard)" @click="good($event, item.iboard)"></i>
                <img src="https://d30y0swoxkbnsm.cloudfront.net/community/20200324/748d6a3d-648e-426b-a705-f47f654b6d4a/%EC%B9%B4%EB%AC%B4%EC%9D%B4.jpg" 
                @click="goToDetail(item.iboard)"
                  class="card-img-top"
                  alt="이미지">
              </div>
            <div class="card-body">
              <h5 class="card-title">{{ item.title }}</h5>
              <p class="card-text">
                <span class="badge bg-dark text-white me-1 pointer" @click="goToMyPage(item.iuser)">작성자:{{ item.nick}}</span>
                <span class="badge bg-dark text-white me-1">area:{{ item.area }}</span>
                <span class="badge bg-dark text-white me-1">location:{{ item.location }}</span>
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
    boardFavList: [],
    favIboardList: [],
    iuser: null
    }
  },
  methods: {
    async boardList() {
      this.list = await this.$get('/board/boardList');
      // console.log(this.list);
    },
    async goToDetail(iboardNum) {
      this.$router.push({name: 'detail', params: {iboard: iboardNum}});
    },
    async favIboard() {
      this.iuser = this.$store.state.user.iuser;
      this.boardFavList = await this.$get(`/board/boardFav/${this.iuser}`, {});
      this.boardFavList.result.forEach(item => {
        this.favIboardList.push(item.iboard);
      });
      console.log(this.favIboardList);
    },
    heartColor(event, iboard) {
      console.log(this.favIboardList);
      console.log(iboard);
      if(this.favIboardList.includes(iboard)){
        return true;
      }else{
        return false;
      }
    },
    async good(event, iboard) {
      if(event.target.classList.contains('fa-regular')){ //검은 하트일 때
        const res = await this.$post(`/board/boardFav/${this.iuser}/${iboard}`);
        if(res.result === 1){ // 좋아요 성공 시
          event.target.classList.remove('fa-regular');
          event.target.classList.add('fa-solid');
          event.target.style.color = "red";
        }
      }else if(event.target.classList.contains('fa-solid')){
        const res = await this.$delete(`/board/boardFav/${this.iuser}/${iboard}`);
        if(res.result === 1){ // 좋아요 취소 성공 시
          event.target.classList.add('fa-regular');
          event.target.classList.remove('fa-solid');
          event.target.style.color = "";
        }
      }
    },
    async goToMyPage(iuserNum) {
      this.$router.push({name: 'mypage', params: {iuser: iuserNum}});
    }
  },

  created() {
    this.boardList();
    this.favIboard();
  },
}

</script>

<style>
.hearticon {
  position: relative;
}
i {
   position : absolute;
   right: 4px;
   top: 4px; 
   cursor: pointer;
 }
 .pointer {
  cursor: pointer;
}

</style>
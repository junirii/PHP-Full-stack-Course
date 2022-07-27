<template>
  <main class="mt-3">
    <div class="container">   
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6"
            :key="item.iboard" v-for="item in list">
            <div class="card" style="width: 18rem;">
              <div class="hearticon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-heart-fill" viewBox="0 0 16 16" v-show="heartColor(item.iboard)">
                  <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-heart" viewBox="0 0 16 16" v-if="!heartColor(item.iboard)">
                  <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                </svg>
                <img src="http://www.newsinside.kr/news/photo/202107/1112546_790699_4239.jpg" 
                @click="goToDetail(item.iboard)"
                  class="card-img-top"
                  alt="이미지">
              </div>
              <div class="card-body">
                <h5 class="card-title">{{item.title}}</h5>
                <p class="card-text">
                  <span class="badge bg-dark text-white me-1">작성자:{{item.nick}}</span>
                  <span class="badge bg-dark text-white me-1">area:{{item.area}}</span>
                  <span class="badge bg-dark text-white me-1">location:{{item.location}}</span>
                </p>
                <small class="text-dark">{{ item.s_date}} ~ {{ item.e_date}}</small>
              </div>
            </div>
        </div>
                      
      </div>
    <router-link :to="{ path: '/Mypage' }">
      <button type="button">마이페이지</button>
    </router-link>
    </div>
  </main>
</template>

<script>

export default {
  data() {
    return{
    list: [],
    boardFavList: [],
    favIboardList: []
    }
  },
  methods: {
    async boardList() {
      this.list = await this.$get('/board/boardList');
      console.log(this.list);
    },
    async goToDetail(iboardNum) {
      this.$router.push({name: 'detail', query: {iboard: iboardNum}});
    },
    async good() {

    },

    async favIboard() {
      const iuser = this.$store.state.user.iuser;
      this.boardFavList = await this.$get(`/board/boardFav/${iuser}`, {});
      this.boardFavList.result.forEach(item => {
        this.favIboardList.push(item.iboard);
      });
      console.log(this.favIboardList);
    },
    heartColor(iboard) {
      if(this.favIboardList.includes(iboard)){
        return true;
      }else{
        return false;
      }
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
   position : relative;
}

svg {
   position : absolute;
   right: 4px;
   top: 4px; 
   cursor: pointer;
 }

</style>
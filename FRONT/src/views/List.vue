<template>
  <main class="mt-3">
    <div class="container">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6" 
            :key="item.iboard" v-for="item in list">
            <div class="card" style="width: 18rem;">
              <div class="hearticon">
                <i class="fa-regular fa-heart"></i>
                <img src="http://www.newsinside.kr/news/photo/202107/1112546_790699_4239.jpg" 
                @click="goToDetail(item.iboard);"
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
      <router-link :to="{ path: '/Mypage' }">
        <button type="button">마이페이지</button>
      </router-link>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      list: []
    }
  },
  methods: {
    async boardList() {
      this.list = await this.$get('/board/boardList');
      console.log(this.list);
    },
    async goToDetail(iboardNum) {
      this.$router.push({ name: 'detail', params: { iboard: iboardNum } });
    },
    /* 작성자 클릭시 작성자의 마이페이지로 이동 */
    async goToMyPage(iuserNum) {
      this.$router.push({ name: 'mypage', params: { iuser: iuserNum } });
    },
  },

  created() {
    this.boardList();
    console.log(this.$store.state.user);
  },
  good() {
    //test!
  }
}

</script>

<style>
.hearticon {
  position: relative;
}

svg {
  position: absolute;
  right: 4px;
  top: 4px;
  cursor: pointer;
}

.pointer {
  cursor: pointer;
}
</style>
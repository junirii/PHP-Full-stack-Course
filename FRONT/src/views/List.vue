<template>

  <body>
    <main class="list mt-3">
      <div class="filter-btn font bolder"  @click="showFilterModal">
        <i class="fa-solid fa-magnifying-glass"></i>
        필터
      </div>
      <div class="container">
        <!-- <button class="btn" type="button" @click="showFilterModal">필터</button> -->
        <FilterModal :show="modalShow" @close="hiddenModal" v-on:update="travelList()"></FilterModal>
        <div class="row" slot="body">
          <div class="col-xl-3 col-lg-4 col-md-6" style="padding: 25px 25px 25px;" :key="item.itravel"
            v-for="item in list">
            <div class="card" style="width: 17rem; height: 27rem;">
              <div class="hearticon">
                <!-- <font-awesome-icon icon="fa-solid fa-heart fa-2x abcd" v-if="heartColor(item.itravel)" style="color: red;" @click="good($event, item.itravel)"/> -->
                <i class="fa-solid fa-heart fa-2x abcd" v-if="heartColor(item.itravel)" style="color: red;"
                  @click="good($event, item.itravel)"></i>
                <i class="fa-regular fa-heart fa-2x abcd" v-if="!heartColor(item.itravel)"
                  @click="good($event, item.itravel)"></i>
                <!-- <div class="card-img-top" @click="goToDetail(item.itravel)">{{item.main_img}}</div> -->
              </div>
              <img :src="`/static/img/travel/${item.itravel}/main/${item.main_img}`"
                   @click="goToDetail(item.itravel)"
                   class="thumbnail card-img-top"
                   style="width: 17rem; height: 16rem;"
                   alt="여행 썸네일">
              <div class="card-body">
                <h5 class="card-title" @click="goToDetail(item.itravel)">{{ item.title }}</h5>
                <p class="card-text">
                  <span class="badge name-tag me-1 pointer" @click="goToMyPage(item.iuser)">작성자:{{ item.nick }}</span>
                  <span class="badge name-tag me-1">
                    지역: {{ item.area_nm }}<span v-if="item.location !== null">/{{ item.location_nm }}</span>
                  </span>
                  <!-- <span class="badge bg-dark text-white me-1">location:{{ item.location }}</span> -->
                </p>
                <small class="text-dark">{{ item.s_date }} ~ {{ item.e_date }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</template>

<script>
import FilterModal from '/src/components/common/FilterModal.vue';
export default {
  data() {
    return{
    list: [],
    travelFavList: [],
    favItravelList: [],
    iuser: null,
    modalShow: false,
    }
  },
  components: {
    FilterModal
  },
  methods: {
    showFilterModal() {
      this.modalShow = true;
    },
    hiddenModal() {
      this.modalShow = false;
    },
    async travelList() {
      const filter = this.$store.state.filter;
      console.log(filter);
      this.list = await this.$post('/travel/travelList', { filter: this.$store.state.filter });
      console.log(this.list);
    },
    async goToDetail(itravelNum) {
      this.$store.state.itravel = itravelNum;
      this.$router.push({name: 'detail'});
    },
    async favItravel() {
      this.iuser = this.$store.state.user.iuser;
      this.travelFavList = await this.$get(`/travel/travelFav/${this.iuser}`, {});
      console.log(this.travelFavList);
      this.travelFavList.result.forEach(item => {
        this.favItravelList.push(item.itravel);
      });
    },
    heartColor(itravel) {
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
      this.$router.push({name: 'mypage', query: {feedIuser: iuserNum}});
    },
  },
  // watch: {
  //   isModalVisible: function() {
  //     if(this.isModalVisible) {
  //       document.documentElement.style.overflow = 'hidden'
  //       return
  //     }
  //     document.documentElement.style.overflow = 'auto'
  //   }
  // },
  created() {
    this.travelList();
    this.favItravel();
  },
}

</script>

<style scoped>
/* html::-webkit-scrollbar {
  display: none;
  overflow: hidden;
  height: 100%;
} */
/* .stop-scroll {
  display: block;
} */
.list { 
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
  font-family: 'LeferiPoint-WhiteA';
  font-weight: bold;
}
.filter-btn {
  text-decoration: none;
  border: 2px solid var(--mainOrange);
  background-color: #fff;
  border-radius: 20px;
  color: var(--mainOrange);
  padding: 7px;
  line-height: 5px;
  transition: all 0.2s;
  width: 78px;
  float: right;
  position: relative;
  right: 173px;
  bottom: 30px;
  cursor: pointer;
}
.filter-btn:hover {
  color: #fff;
  background-color: var(--mainOrange);
}
.hearticon {
  position: relative;
}
.thumbnail:hover {
  
  /* transition: transform 1s; */
  filter: brightness(70%);
}
.name-tag {
  background-color: #fff;
  color: var(--maincolor);
}
.abcd{
  position : absolute;
  right: 4px;
  top: 4px; 
  cursor: pointer;
 }
.pointer {
  cursor: pointer;
}
.card-body {
  font-family: 'LeferiPoint-WhiteA';
  font-weight: bold;
}

</style>
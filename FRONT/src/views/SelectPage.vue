<template>
  <div class="total">
    <!-- state bar -->
    <div class="state-tab-container">
      <a href="#location" class="state-tab">지역</a>
      <a href="#filter" class="state-tab">옵션</a>
      <a href="#date" class="state-tab">날짜</a>
      <span class="state-slider"></span>
    </div>

    <!-- 지역 상관 x 버튼 -->
    <div class="anywhere">
      <button class="anywhereBtn" alt="어디든지" @click="goToAllList">가보자고</button>
    </div>

    <div id="location">
      <div>
        <h3>여행지 선택</h3>
      </div>
      <div class="box d-flex">
        <div class="container-map">
          <a href="#filter">
            <div class="sec1">
              <img class="center" src="../../mapImg/i.png" alt="수도권" @click="selectArea($event)">
              <img class="gang" src="../../mapImg/Gang.png" alt="강원도" @click="selectArea($event)">
            </div>
            <div class="sec2">
              <div class="K">
                <img class="K1" src="../../mapImg/k.png" alt="경상북도" @click="selectArea($event)">
                <img class="I" src="../../mapImg/island.png" alt="울릉/독도" @click="selectArea($event)">
              </div>
              <img class="C1" src="../../mapImg/chung1.png" alt="충청북도" @click="selectArea($event)">
              <img class="C2" src="../../mapImg/chung2.png" alt="충청남도" @click="selectArea($event)">
            </div>
            <div class="sec3">
              <img class="K2" src="../../mapImg/k2.png" alt="경상남도" @click="selectArea($event)">
              <img class="J1" src="../../mapImg/j1.png" alt="전라북도" @click="selectArea($event)">
              <img class="J2" src="../../mapImg/j2.png" alt="전라남도" @click="selectArea($event)">
              <img class="JJ" src="../../mapImg/jj.png" alt="제주도" @click="selectArea($event)">
            </div>
            <img class="map" src="../../mapImg/map_1.png" alt="map">
          </a>
        </div>
      </div>
    </div>

    <div id="filter">
      <h3>옵션 선택</h3>
      <div>
        <div>인원:
          <label for="two">2명</label>
          <input v-model="filter.f_people" type="radio" id="two" name="people" value="2">
          <label for="three">3명</label>
          <input v-model="filter.f_people" type="radio" id="three" name="people" value="3">
          <label for="four">4명</label>
          <input v-model="filter.f_people" type="radio" id="four" name="people" value="4">
          <label for="five">5명</label>
          <input v-model="filter.f_people" type="radio" id="five" name="people" value="5">
          <label for="six">6명</label>
          <input v-model="filter.f_people" type="radio" id="six" name="people" value="6">
          <label for="seven">7명</label>
          <input v-model="filter.f_people" type="radio" id="seven" name="people" value="7">
          <label for="eight">8명 이상</label>
          <input v-model="filter.f_people" type="radio" id="eight" name="people" value="8">
        </div>
        <br>

        <div>성별 :
          <label for="male">남성</label>
          <input v-model="filter.f_gender" type="radio" id="male" name="gender" value="1">
          <label for="female">여성</label>
          <input v-model="filter.f_gender" type="radio" id="female" name="gender" value="2">
          <label for="nolimit_gender">혼성</label>
          <input v-model="filter.f_gender" type="radio" id="nolimit_gender" name="gender" value="3">
        </div>
        <br>

        <!-- select option으로 바꾸기 나이제한없음, 20, 30, 40, 50, 20~30, 30~40, 40~50대(value값: 0~8)-->
        <!-- 테이블 t_age 사용할 것 -->
        <div>연령 :
          <select v-model="filter.f_age">
            <option value="1">20대</option>
            <option value="2">30대</option>
            <option value="3">40대</option>
            <option value="4">50대</option>
            <option value="5">20~30대</option>
            <option value="6">30~40대</option>
            <option value="7">40~50대</option>
            <option value="8">제한없음</option>
          </select>
        </div>
        <br>

        <div>비용 :
          최소 <input v-model="filter.l_price" type="number" step="1000">원 ~ 최대 <input v-model="filter.h_price"
            type="number" step="1000">원
        </div>
      </div>
      <div>
        <a href="#date">
          <button class="btn" type="button">↓</button>
        </a>
      </div>
    </div>

    <div id="date">
      <h3>날짜 선택</h3>
      <div>
        <Datepicker v-model="date" range multiCalendars :multiStatic="false" :enableTimePicker="false" />
      </div>

      <div class="moveToListBtn">
        <router-link :to="{ path: '/List' }">
          <button class="btn" type="button" @click="moveToList()">여행 찾기</button>
        </router-link>
      </div>
    </div>
  </div> <!-- div total 닫음 -->

</template>

<script>
import { ref, onMounted } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
    
export default {
components: { Datepicker },
  setup() {
    const date = ref();
    onMounted(() => {
      const startDate = new Date() ;
      const endDate = new Date(new Date().setDate(startDate.getDate()) );
      date.value = [startDate, endDate];
    })
    return{
      date,
    }
  },
  data() {
    return {
      areaList: [],
      filter: {
        selectedArea: [],
        selectedLocation: null,
        f_people: 0,
        f_gender: 0,
        f_age: 0,
        l_price: 10000,
        h_price: 5000000,
        s_date: '',
        e_date: '',
      }
    };
  },
  created() {
    this.getAreaList();
    this.getPrice();
  },
  methods: {
    async getPrice(){
      const res = await this.$get('/travel/getPrice');
      if(res.result){
        this.filter.h_price = res.result.max;
        this.filter.l_price = res.result.min;
        console.log(this.filter);
      }
    },
    async getAreaList() {
      this.areaList = await this.$get('/travel/areaList', {});
    },
    selectArea(e){
      switch(e.target.alt){
        case "수도권":
          this.filter.selectedArea = [1, 2, 8];
          break;
        case '강원도':
          this.filter.selectedArea = [9];
          break;
        case '충청북도':
          this.filter.selectedArea = [10];
          break;
        case '충청남도':
          this.filter.selectedArea = [6, 11];
          break;
        case '경상북도':
          this.filter.selectedArea = [5, 12];
          break;
        case '경상남도':
          this.filter.selectedArea = [3, 4, 13];
          break;
        case '전라북도':
          this.filter.selectedArea = [14];
          break;
        case '전라남도':
          this.filter.selectedArea = [7, 15];
          break;
        case '제주도':
          this.filter.selectedArea = [16];
          break;
      }
    },
    moveToList(){
      const s_year = this.date[0].getFullYear();
      const s_month =  ("0" + (this.date[0].getMonth() + 1)).slice(-2);
      const s_day = ("0" + this.date[0].getDate()).slice(-2);
      this.filter.s_date = `${s_year}-${s_month}-${s_day}`;

      const e_year = this.date[1].getFullYear();
      const e_month = ("0" + (this.date[1].getMonth() + 1)).slice(-2);
      const e_day = ("0" + this.date[1].getDate()).slice(-2);
      this.filter.e_date = `${e_year}-${e_month}-${e_day}`;

      this.$store.state.filter = this.filter;
      console.log(this.$store.state.filter);
    },
    goToAllList(){
      this.filter = {
        selectedArea: [],
        selectedLocation: null,
        f_people: 0,
        f_gender: 0,
        f_age: -1,
        l_price: 10000,
        h_price: 5000000,
        s_date: '1900-01-01',
        e_date: '2032-08-06',
      };
      this.$store.state.filter = this.filter;
      console.log(this.$store.state.filter);

      this.$router.push({name: 'list'});
    }
  }
};
</script>

<style scoped>

.total { /* 페이지 전체 */
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}

/* state bar */
.state-tab-container {
  display: grid;
  position: fixed;
  top: 440px;
  left: 69px;
  width: 100px;
  height: 140px;
  z-index: 10;
}

.state-tab {
  display: flex;
  justify-content: center;
  align-items: center;
  flex: 1;
  color: var(--mainDark);
  letter-spacing: 0.1rem;
  transition: all 0.5s ease;
  font-size: 1rem;
  font-weight: bold;
}
.state-tab:hover {
  color: var(--maincolor);
}

.state-slider { /* 보류 */
  position: fixed;
  top: 460px;
  width: 6px;
  height: 0;
  background: #66B1F1;
  transition: left 0.3s ease;
}
.anywhereBtn {
  position: fixed;
  bottom: 111px;
  right: 220px;
  width: 80px;
  height: 80px;
  z-index: 10;

  border-radius: 50%;
  width: 100px;
  height: 100px;
  border: 0px;
  background-color: var(--maincolor);
  color: white;
  font-weight: bold;
  box-shadow: 0 8px 8 #285d92; 
}
.anywhereBtn:active {
    transform: translateY(4px);
    box-shadow: 0 4px 0 #2d7ac2;
}
.box { /* 지도 전체 틀 */
  margin-top: 100px;
  justify-content: center;
}

img {
  vertical-align: middle;
  cursor: pointer;
}

.map { /* 지도 밑판 */
  max-width: 500px;
}

.sec1, .sec2, .sec3 { /* 위치별 지역 묶음 */
  position: absolute;
}

.center {
  max-width: 170px;
  position: absolute;
  top: 24px;
  left: 13px;
}

.gang {
  max-width: 225px;
  position: absolute;
  left: 114px;
  top: 1px;
}

.K1 {
  position: absolute;
  top: 172px;
  max-width: 178px;
  left: 188px;
}

.K2 {
  position: absolute;
  max-width: 190px;
  top: 333px;
  left: 162px;
}

.C1 {
  position: absolute;
  max-width: 135px;
  top: 156px;
  left: 126px;
}

.C2 {
  position: absolute;
  max-width: 156px;
  top: 182px;
  left: 5px;
}

.J1 {
  position: absolute;
  max-width: 150px;
  top: 300px;
  left: 36px;
}

.J2 {
  position: absolute;
  max-width: 176px;
  top: 388px;
  left: -2px;
}

.JJ {
  position: absolute;
  max-width: 81px;
  top: 575px;
  left: 2px;
}

.I {
  position: absolute;
  max-width: 59px;
  top: 189px;
  left: 439px;
}
/* 지역별 hover 효과 */
.center:hover, .C1:hover, .C2:hover, .J1:hover, .J2:hover, .JJ:hover {
  transform: translateX(-5px);
  transition: 0.3s;
}
.gang:hover, .K:hover, .K2:hover {
  transform: translateX(6px);
  transition: 0.3s;
}
/* 지도 css 끝*/

/* 섹션별 간격 */
#location, #filter, #date {
  padding: 100px;
}
/* 여행찾기 버튼 */
.moveToListBtn {
  padding: 10px;
}
</style>
<template>
  <div class="total">
    <!-- 상태바 -->
    <div class="state-tab-container">
      <!-- <a href="#location" class="state-tab">지역</a> -->
      <div class="state-tab" @click="scrollToLocation">지역</div>
      <div class="state-tab" @click="scrollToFilter">옵션</div>
      <div class="state-tab" @click="scrollToDate">날짜</div>
      <!-- <a href="#filter" class="state-tab">옵션</a>
      <a href="#date" class="state-tab">날짜</a> -->
      <span class="state-slider"></span>
    </div>

    <!-- 지역 상관 x 버튼 -->
    <div class="anywhere">
      <router-link :to="{ path: '/List' }">
        <button class="anywhere-btn" alt="whenever anywhere" @click="moveToList()">
        {{this.list.length}}개<br>여행 보기</button>
      </router-link>
    </div>

    <!-- 지역 -->
    <div id="location">
      <div>
        <h3>Step 1. 여행지 선택</h3>
        <h6>떠나고 싶은 여행지를 선택하세요.</h6>
        <h4 class="area-name"> {{ areaName }} </h4>
      </div>
      <div class="box d-flex">
        <div class="container-map">
          <div class="sec1">
            <img class="center" src="../../mapImg/i.png" alt="수도권"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
            <img class="gang" src="../../mapImg/Gang.png" alt="강원도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
          </div>
          <div class="sec2">
            <div class="K">
              <img class="K1" src="../../mapImg/k.png" alt="경상북도"
                @click="[selectArea($event),insAreaName($event),changeFilter()]">
              <img class="I" src="../../mapImg/island.png" alt="경상북도"
                @click="[selectArea($event),insAreaName($event),changeFilter()]">
            </div>
            <img class="C1" src="../../mapImg/chung1.png" alt="충청북도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
            <img class="C2" src="../../mapImg/chung2.png" alt="충청남도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
          </div>
          <div class="sec3">
            <img class="K2" src="../../mapImg/k2.png" alt="경상남도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
            <img class="J1" src="../../mapImg/j1.png" alt="전라북도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
            <img class="J2" src="../../mapImg/j2.png" alt="전라남도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
            <img class="JJ" src="../../mapImg/jj.png" alt="제주도"
              @click="[selectArea($event),insAreaName($event),changeFilter()]">
          </div>
          <img class="map" src="../../mapImg/map_1.png" alt="map">
        </div>
      </div>
      <!-- <a href="#filter">
        <button class="btn next-btn" type="button">다음</button>
      </a> -->
    </div>

    <hr>

    <!-- 옵션 -->
    <div id="filter">
      <h3>Step 2. 옵션 선택</h3>
      <h6>여행의 옵션을 선택하세요.</h6>
       <h4 class="area-name"> {{ options1 }} {{ options2 }} {{ options3 }} {{ options4 }}</h4>
      <div class="filter-box">
        <div class="people-box">
          <span class="filter-name">인원</span>
          <div class="choose-people">
            <div :key="item.idx" v-for="item in peopleList">
              <input class="radio-btn" @change="changeFilter" type="radio" v-model="filter.f_people"
                     :id="`people${item.people}`" :value="item.idx" name="people"
                     @input="options1 = $event.target.value" />
              <label :for="`people${item.people}`">{{ item.people }}</label>
            </div>
          </div>
        </div>
        

        <div class="gender-box">
          <span class="filter-name">성별</span>
          <div class="choose-gender">
            <div :key="item.idx" v-for="item in genderList">
              <input class="radio-btn" @change="changeFilter" type="radio" v-model="filter.f_gender"
                     :id="`gender${item.gender}`" :value="item.idx" name="gender"
                     @input="options2 = $event.target.value" />
              <label :for="`gender${item.gender}`">{{ item.gender }}</label>
            </div>
          </div>
        </div>

        <div class="age-box">
          <span class="filter-name">연령</span>
          <div class="choose-age">
            <div :key="item.idx" v-for="item in ageList">
              <input class="radio-btn" @change="changeFilter" type="radio" v-model="filter.f_age" :id="`${item.age}`"
                :value="item.idx"
                @input="options3 = $event.target.id" />
              <label :for="`${item.age}`">{{ item.age }}</label>
            </div>
          </div> 
        </div>

        <div class="price-box">
          <span class="filter-name">비용</span>
          <div class="choose-price">
            최소 <input @change="changeFilter" v-model="filter.l_price" type="number" step="10000"/> 원 ~
            최대 <input @change="changeFilter" v-model="filter.h_price" type="number" step="10000"/> 원
          </div>
        </div>
      </div>
    </div>

    <hr>

    <div id="date">
      <h3>Step 3. 날짜 선택</h3>
      <h6>떠나고 싶은 날짜를 선택하세요.</h6>
      <div class="date-input">
        <Datepicker @update:modelValue="handleDate" class="date-picker" inline autoApply locale="ko-KR" v-model="date"
          range multiCalendars :multiStatic="false" :enableTimePicker="false" :minDate="new Date()" />
      </div>
      <button @click="test">test</button>
      <div class="move-to-list-btn">
        <router-link :to="{ path: '/List' }">
          <button class="btn next-btn" type="button" @click="moveToList">여행 찾기</button>
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
    const handleDate = (modelData) => {
      date.value = modelData;
      const s_year = date.value[0].getFullYear();
      const s_month =  ("0" + (date.value[0].getMonth() + 1)).slice(-2);
      const s_day = ("0" + date.value[0].getDate()).slice(-2);
      const sdate = `${s_year}-${s_month}-${s_day}`;

      const e_year = date.value[1].getFullYear();
      const e_month = ("0" + (date.value[1].getMonth() + 1)).slice(-2);
      const e_day = ("0" + date.value[1].getDate()).slice(-2);
      const edate = `${e_year}-${e_month}-${e_day}`;
      globalThis.this.filter.s_date= sdate;
      globalThis.this.filter.e_date= edate;
      globalThis.this.changeFilter();
    }
    onMounted(() => {
      const startDate = new Date() ;
      const endDate = new Date(new Date().setDate(startDate.getDate()) );
      date.value = [startDate, endDate];
    })
    return{
      date,
      handleDate,
    }
  },
  mounted() {

  },
  data() {
    return {
      areaList: [],
      ageList: [],
      genderList: [],
      peopleList: [],
      list: [],
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
      },
      areaName: '',
      options: '',
    };
  },
  created() {
    globalThis.this = this;
    this.getAreaList();
    this.getPrice();
    this.getAgeList();
    this.getGenderList();
    this.getPeopleList();
    this.changeFilter();
  },
  methods: {
    dateIntoFilter(){
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
      // this.changeFilter();
    },
    test(){
      console.log(this.date);
      console.log(this.handleDate);
      const datePicker = document.querySelector('#datePicker');
      console.log(datePicker);
    },
    async changeFilter() {
      this.$store.state.filter = this.filter;
      this.list = await this.$post('/travel/travelList', { filter: this.$store.state.filter });
      console.log(this.list);
    },
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
    async getAgeList() {
      this.ageList = await this.$get('/travel/ageList', {});
      console.log(this.ageList);
    },
    async getGenderList() {
      this.genderList = await this.$get('/travel/genderList', {});
      console.log(this.genderList);
    },
    async getPeopleList() {
      this.peopleList = await this.$get('/travel/peopleList', {});
      console.log(this.peopleList);
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
    insAreaName(e) {
      this.areaName = e.target.alt;
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
        f_age: 0,
        l_price: 10000,
        h_price: 5000000,
        s_date: '1900-01-01',
        e_date: '2032-08-06',
      };
      this.$store.state.filter = this.filter;
      console.log(this.$store.state.filter);

      this.$router.push({name: 'list'});
    },
    scrollToLocation() {
      const location = document.querySelector("#location").offsetTop;
      window.scrollTo({ left: 0, top: location, behavior: "smooth" });
    },
    scrollToFilter() {
      const filter = document.querySelector("#filter").offsetTop;
      window.scrollTo({ left: 0, top: filter, behavior: "smooth" });
    },
    scrollToDate() {
      const date = document.querySelector("#date").offsetTop;
      window.scrollTo({ left: 0, top: date, behavior: "smooth" });
    }
  }
};
</script>

<style scoped>

.total { /* 페이지 전체 */
  z-index: auto;
  margin: 0 auto;
  padding: 30px;
  color: var(--maincolor);
}
h3 {
  font-weight: bolder;
  text-decoration: underline;
  text-underline-offset : 10px;
}
h4, h6 { 
  font-weight: bolder;
  padding: 15px;
}
h6 {
  padding-bottom: 0;
}
h4 {
  color: var(--mainOrange);
}
.area-name {
  padding: 20px;
}
hr {
  height: 2px;
  color: var(--maincolor);
  width: 50%;
  margin: 0 auto;
}

/* state bar */
.state-tab-container {
  display: grid;
  position: fixed;
  top: 440px;
  left: 122px;
  width: 80px;
  height: 140px;
  z-index: 10;
}
.state-tab {
  display: flex;
  justify-content: center;
  align-items: center;
  flex: 1;
  color: var(--mainOrange);
  letter-spacing: 0.1rem;
  /* transition: all 0.5s ease; */
  font-size: 1rem;
  font-weight: bold;
}
.state-tab:hover {
  border: none;
  border-left: 2px solid var(--mainDarkOrange);
}
.anywhere-btn {
  position: fixed;
  bottom: 175px;
  right: 220px;
  transition: all 0.2s;

  border-radius: 50%;
  width: 100px;
  height: 100px;
  border: 2px solid var(--maincolor);
  background-color: #fff;

  color: var(--maincolor);
  font-weight: bolder;
  text-align: center;
}
.anywhere-btn:hover {
  color: #fff;
  background-color: var(--maincolor);
}
.anywhere-btn:active {
    transform: translateY(4px);
}
.box { /* 지도 전체 틀 */
  margin-top: 40px;
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
.next-btn {
  margin-top: 50px;
}
/* 지도 css 끝*/

/* 옵션 */
.filter-box {
  border: 1px solid var(--maincolor);
  width: 50%;
  height: 500px;
  margin: 0 auto;
  text-align: left;
}
.filter-name {
  margin-bottom: 7px;
  margin-left: 14px;
}
.people-box, .gender-box, .age-box, .price-box {
  display: flex !important;
  flex-direction: column !important;
  padding: 29px;
}
.choose-people, .choose-gender, .choose-age {
  /* padding-top: 10px;
  padding-left: 20px; */
  display: flex;
  flex-direction: row;
}
 .choose-price {
  margin-left: 14px;
  color: var(--mainOrange);
 }
.radio-btn {
  opacity: 0;
}
label {
  text-align: center;
  padding: 5px 10px;
  color: var(--mainOrange);
  border: 2px solid var(--mainOrange);
  border-radius: 18px;
  height: 34px;
}

input[type=radio]:checked + label {
  background-color: var(--mainOrange);
  color: #fff;
}

/* 날짜 */
.date-input {
  margin: 0 auto;
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

/* 섹션별 간격 */
#location, #filter, #date{
  padding: 100px 0;
}
#date {
  padding-bottom: 10rem;
} 
/* 여행찾기 버튼 */
.move-to-list-btn {
  padding: 10px;
}
</style>
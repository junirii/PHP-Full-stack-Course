<template>
  <div class="total">
    <!-- state bar -->
    <div id="stateNav">
      <ul>
        <li>
          <a href="#location"><span></span></a>
          <div class="stateBar">지역</div>
        </li>
        <li>
          <a href="#filter"><span></span></a>
          <div class="stateBar">옵션</div>
        </li>
        <li>
          <a href="#date"><span></span></a>
          <div class="stateBar">날짜</div>
        </li>
      </ul>
    </div>

    <div id="location">
      <div>
        <h3>여행지 선택</h3>
      </div>
      <div>
        <span>지역</span>
        <select v-model="filter.selectedArea">
            <option value="" selected>전체</option>
            <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
        </select>
      </div>
      <!-- <router-link :to="{ path: '#' }">
        <button type="button">↓</button>
      </router-link> -->
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
        <form>
          <div>인원: 
            <input type="number" v-model="filter.f_people">명
          </div>
          <br>

          <div>성별 : 
            <label for="male">남성</label>
            <input v-model="filter.f_gender" type="radio" id="male" name="gender" value="1">
            <label for="female">여성</label>
            <input v-model="filter.f_gender" type="radio" id="female" name="gender" value="2">
            <label for="nolimit_gender">상관없음</label>
            <input v-model="filter.f_gender" type="radio" id="nolimit_gender" name="gender" value="0">
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
              <option value="0">제한없음</option>
            </select>
          </div>
          <br>

          <div>비용 :
            <input v-model="filter.l_price" type="number" step="1000">~<input v-model="filter.h_price" type="number" step="1000">원
          </div>
        </form>
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
        출발일
        <input v-model="filter.s_date" type="date" name="startDay">
        도착일
        <input v-model="filter.e_date" type="date" name="endDay">
      </div>
      <section class="section">
        <div class="container">
          <h2 class="subtitle has-text-centered">
            <button class="button is-small is-primary is-outlined mr-5" @click="calendarData(-1)">&lt;</button>
            {{ year }}년 {{ month }}월
            <button class="button is-small is-primary is-outlined ml-5" @click="calendarData(1)">&gt;</button>
          </h2>
          <table class="table has-text-centered is-fullwidth">
            <thead>
              <th v-for="day in days" :key="day">{{ day }}</th>
            </thead>
            <tbody>
              <tr v-for="(date, idx) in dates" :key="idx">
                <td v-for="(day, secondIdx) in date" :key="secondIdx" :class="{
                  'has-text-info-dark': idx === 0 && day >= lastMonthStart,
                  'has-text-danger': dates.length - 1 === idx && nextMonthStart > day,
                  'has-text-primary': day === today && month === currentMonth && year === currentYear
                }">
                  {{ day }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
      <div class="moveToListBtn">
        <router-link :to="{ path: '/List' }">
          <button class="btn" type="button" @click="saveFilter">여행 찾기</button>
        </router-link>
      </div>
    </div>
  </div> <!-- div total 닫음 -->

</template>

<script>
export default {
  data() {
    return {
      days: [
        '일요일',
        '월요일',
        '화요일',
        '수요일',
        '목요일',
        '금요일',
        '토요일',
      ],
      dates: [],
      currentYear: 0,
      currentMonth: 0,
      year: 0,
      month: 0,
      lastMonthStart: 0,
      nextMonthStart: 0,
      today: 0,
      areaList: [],
      filter: {
        selectedArea: [],
        f_people: 0,
        f_gender: 0,
        f_age: 0,
        l_price: 0,
        h_price: 0,
        s_date: '',
        e_date: ''
      }
    };
  },
  created() { // 데이터에 접근이 가능한 첫 번째 라이프 사이클
    const date = new Date();
    this.currentYear = date.getFullYear(); // 이하 현재 년, 월 가지고 있기
    this.currentMonth = date.getMonth() + 1;
    this.year = this.currentYear;
    this.month = this.currentMonth;
    this.today = date.getDate(); // 오늘 날짜
    this.calendarData();
    this.getAreaList();
  },
  methods: {
    calendarData(arg) { // 인자를 추가
      if (arg < 0) { // -1이 들어오면 지난 달 달력으로 이동
        this.month -= 1;
      } else if (arg === 1) { // 1이 들어오면 다음 달 달력으로 이동
        this.month += 1;
      }
      if (this.month === 0) { // 작년 12월
        this.year -= 1;
        this.month = 12;
      } else if (this.month > 12) { // 내년 1월
        this.year += 1;
        this.month = 1;
      }
      const [
        monthFirstDay,
        monthLastDate,
        lastMonthLastDate,
      ] = this.getFirstDayLastDate(this.year, this.month);
      this.dates = this.getMonthOfDays(
        monthFirstDay,
        monthLastDate,
        lastMonthLastDate,
      );
    },
    getFirstDayLastDate(year, month) {
      const firstDay = new Date(year, month - 1, 1).getDay(); // 이번 달 시작 요일
      const lastDate = new Date(year, month, 0).getDate(); // 이번 달 마지막 날짜
      let lastYear = year;
      let lastMonth = month - 1;
      if (month === 1) {
        lastMonth = 12;
        lastYear -= 1;
      }
      const prevLastDate = new Date(lastYear, lastMonth, 0).getDate(); // 지난 달 마지막 날짜
      return [firstDay, lastDate, prevLastDate];
    },
    getMonthOfDays(
      monthFirstDay,
      monthLastDate,
      prevMonthLastDate,
    ) {
      let day = 1;
      let prevDay = (prevMonthLastDate - monthFirstDay) + 1;
      const dates = [];
      let weekOfDays = [];
      while (day <= monthLastDate) {
        if (day === 1) {
          // 1일이 어느 요일인지에 따라 테이블에 그리기 위한 지난 셀의 날짜들을 구할 필요가 있다.
          for (let j = 0; j < monthFirstDay; j += 1) {
            if (j === 0) this.lastMonthStart = prevDay; // 지난 달에서 제일 작은 날짜
            weekOfDays.push(prevDay);
            prevDay += 1;
          }
        }
        weekOfDays.push(day);
        if (weekOfDays.length === 7) {
          // 일주일 채우면
          dates.push(weekOfDays);
          weekOfDays = []; // 초기화
        }
        day += 1;
      }
      const len = weekOfDays.length;
      if (len > 0 && len < 7) {
        for (let k = 1; k <= 7 - len; k += 1) {
          weekOfDays.push(k);
        }
      }
      if (weekOfDays.length > 0) dates.push(weekOfDays); // 남은 날짜 추가
      this.nextMonthStart = weekOfDays[0]; // 이번 달 마지막 주에서 제일 작은 날짜
      return dates;
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
    saveFilter(){
      this.$store.state.filter = this.filter;
    }
  }
};
</script>

<style scoped>
.total {
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.sidebar {
  width: 5px;
  height: 500px;
  background-color: var(--maincolor);
  display: flex;
  position: fixed;
  /* bottom: 100px; */
}

.box { /* 지도 전체 틀 */
  margin-top: 100px;
  /* float: left; */
  /* position: relative; */
  /* display: flex; */
  justify-content: center;
  /* align-items: center; */
}

img {
  vertical-align: middle;
  cursor: pointer;
}

.map {
  max-width: 500px;
  /* position: relative;
  top: 0;
  left: 0; */
}

.sec1,
.sec2,
.sec3 {
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

.center:hover,
.C1:hover,
.C2:hover,
.J1:hover,
.J2:hover,
.JJ:hover {
  transform: translateX(-5px);
  transition: 0.3s;
}
.gang:hover, .K:hover, .K2:hover {
  transform: translateX(6px);
  transition: 0.3s;
}

#location,
#filter,
#date {
  padding: 100px;
}

.moveToListBtn {
  padding: 10px;
}
</style>
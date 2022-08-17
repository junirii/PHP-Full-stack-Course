<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper" @click="$emit('close')">
        <div class="modal-container" @click.stop="">
          <div class="modal-header">
            <div name="header" style="font-size: 20px; color: var(--maincolor);">필터</div>
            <button class="modal-cancel-btn" @click="$emit('close')">X</button>
          </div>

          <div class="modal-body">
            <slot name="body">
              <div class="map-box">
                <span class="filter-name">지역</span>
                <br>
                <div class="choose">
                  <select class="choose-area bolder" v-model="selectedArea" @change="showLocationOption()">
                    <option class="bolder" value="" selected>전체</option>
                    <option class="bolder" :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
                  </select>
                  <select class="bolder" v-model="selectedLocation" v-if="locationList.length > 1">
                    <option class="bolder" value="" selected>전체</option>
                    <option class="bolder" :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{ item.location_nm
                      }}</option>
                  </select>
                </div>
              </div>
              <hr>
              <div class="date-box">
                <span class="filter-name">날짜</span>
                <div class="choose">
                  <Datepicker class="choose-date" v-model="date" range multiCalendars :multiStatic="false" :enableTimePicker="false"
                    :minDate="new Date()" />
                </div>
              </div>
              <hr>
              <div class="people-box">
                <span class="filter-name">인원</span>
                <div class="choose-people choose">
                  <div :key="item.idx" v-for="item in peopleList">
                    <input class="radio-btn" @change="changeFilter" type="radio" v-model="filter.f_people"
                      :id="`people${item.people}`" :value="item.idx" name="people" />
                    <label :for="`people${item.people}`">{{ item.people }}</label>
                  </div>
                </div>
              </div>
              <hr>
              <div class="gender-box">
                <span class="filter-name">성별</span>
                <div class="choose-gender choose">
                  <div :key="item.idx" v-for="item in genderList">
                    <input class="radio-btn" @change="changeFilter" type="radio" v-model="filter.f_gender"
                      :id="`gender${item.gender}`" :value="item.idx" name="gender" />
                    <label :for="`gender${item.gender}`">{{ item.gender }}</label>
                  </div>
                </div>
              </div>
              <hr>
              <div class="age-box">
                <span class="filter-name">연령</span>
                <div class="choose-age choose">
                  <div :key="item.idx" v-for="item in ageList">
                    <input class="radio-btn" @change="changeFilter" type="radio" v-model="filter.f_age"
                      :id="`age${item.age}`" :value="item.idx" name="age"/>
                    <label :for="`age${item.age}`">{{ item.age }}</label>
                  </div>
                </div>
              </div>
              <hr>
              <div class="price-box">
                <span class="filter-name">비용</span>
                <div class="choose-price choose">
                  <span>최소<input type="number" v-model="filter.l_price" step="10000" id="number" min="0"></span><br>
                  <span>최대<input type="number" v-model="filter.h_price" step="10000" id="number" min="0"></span>
                </div>
              </div>
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              <router-link :to="{ path: '/List' }">
                <button class="modal-submit-btn" type="button" @click="moveToFilterList()">여행 찾기</button>
              </router-link>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script>
import { ref, onMounted } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
// import { isThisHour, nextDay } from 'date-fns';

export default {
  components: {
    Datepicker
  },
  setup() {
    const date = ref();
    onMounted(() => {
      const startDate = new Date();
      const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
      date.value = [startDate, endDate];
    })
    return {
      date,
    }
  },
  data() {
    return {
      areaList: [],
      locationList: [],
      ageList: [],
      genderList: [],
      peopleList: [],
      selectedArea: '',
      selectedLocation: '',
      filter: {
        selectedArea: [],
        selectedLocation: null,
        s_date: '',
        e_date: '',
        f_people: 0,
        f_gender: 0,
        f_age: 0,
        l_price: 0,
        h_price: 0,
      }
    }
  },
  props: {
    show: Boolean
  },
  created() {
    this.getAreaList();
    this.getLocationList();
    this.getAgeList();
    this.getGenderList();
    this.getPeopleList();
    this.getPrice();
  },
  methods: {
    async getAreaList() {
      this.areaList = await this.$get('/travel/areaList', {});
      console.log(this.areaList);
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
    async getLocationList(iarea) {
      this.locationList = await this.$get(`/travel/locationList/${iarea}`, {});
      console.log(this.locationList);
    },
    async getAgeList() {
      this.ageList = await this.$get('/travel/ageList', {});
      console.log(this.ageList);
    },
    showLocationOption() {
      this.selectedLocation = '';
      this.locationList = [];
      this.getLocationList(this.selectedArea);
    },
    async getPrice(){
      const res = await this.$get('/travel/getPrice');
      if(res.result){
        this.filter.h_price = res.result.max;
        this.filter.l_price = res.result.min;
        console.log(this.filter);
      }
    },
    moveToFilterList() {
      this.filter.selectedArea.push(this.selectedArea);
      if (this.selectedLocation) {
        this.filter.selectedLocation = this.selectedLocation;
      } else {
        this.filter.selectedLocation = null;
      }

      const s_year = this.date[0].getFullYear();
      const s_month =  ("0" + (this.date[0].getMonth() + 1)).slice(-2);
      const s_day = ("0" + this.date[0].getDate()).slice(-2);
      this.filter.s_date = `${s_year}-${s_month}-${s_day}`;
      // this.filter.s_date = '1900-01-01';

      const e_year = this.date[1].getFullYear();
      const e_month = ("0" + (this.date[1].getMonth() + 1)).slice(-2);
      const e_day = ("0" + this.date[1].getDate()).slice(-2);
      this.filter.e_date = `${e_year}-${e_month}-${e_day}`;
      // this.filter.e_date = '2032-08-06';

      if(this.selectedArea == 0) {
        this.filter.selectedArea = [];
      }

      this.$store.state.filter = this.filter;
      console.log(this.$store.state.filter);
      this.clearFilter();
      this.$emit('close');
      this.$emit('update');
    },
    clearFilter(){
      this.filter = {
        selectedArea: [],
        selectedLocation: null,
        s_date: '',
        e_date: '',
        f_people: 0,
        f_gender: 0,
        f_age: 0,
        s_date: '',
        e_date: '',
        l_price: this.filter.l_price,
        h_price: this.filter.h_price,
      };
    }
  }
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 637px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}
.modal-cancel-btn, .modal-submit-btn {
  border: 0;
  background: none;
  font-weight: bolder;
  color: var(--mainOrange);
  font-size: 20px;
}
.modal-submit-btn {
  padding-top: 20px;
}
.modal-body {
  margin: 20px 0;
}

.modal-footer {
  text-align: center;
  display: flex;
  justify-content: center;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.modal-body {
  height: 637px;
  overflow-y: auto;
}
hr { color: var(--maincolor); }
.filter-name {
  padding-bottom: 30px;
  font-size: 20px;  
  color: var(--maincolor);
}
.map-box, .date-box, .people-box, .gender-box, .age-box, .price-box {
  padding-bottom: 20px;
}
.map-box > .choose > select, .map-box > .choose > input {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;

    border: none;
    border-bottom: 2px solid var(--maincolor);
    width: 50px;
    height: 25px;
    padding-left: 10px;
    color: var(--maincolor);
}
select:hover, input:hover {
    border-bottom: 2px solid var(--mainDark);
    cursor: pointer;    
}
.map-box > select::-ms-expand { display: none; }
select:focus { 
    border: 2px solid var(--mainDark);
}
.choose { padding-top: 30px; }
.choose-date {
  width: 300px;
  margin: 0 auto;
}
.choose-people, .choose-gender{
  display: flex;
  flex-direction: row;
  justify-content: center;
}
.choose-age {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
}
.choose-age > div {
  padding: 5px;
}
.choose-price {
  margin-left: 14px;
  color: var(--maincolor);
 }
.radio-btn {
  opacity: 0;
}
label {
  text-align: center;
  padding: 5px 10px;
  color: var(--maincolor);
  border: 2px solid var(--maincolor);
  border-radius: 18px;
  height: 34px;
}

input[type=radio]:checked + label {
  background-color: var(--maincolor);
  color: #fff;
}
</style>
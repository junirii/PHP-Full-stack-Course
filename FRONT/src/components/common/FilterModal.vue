<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper" @click="$emit('close')">
        <div class="modal-container" @click.stop="">
          <div class="modal-header">
            <slot name="header">필터</slot>
            <button @click="$emit('close')">X</button>
          </div>

          <div class="modal-body">
            <slot name="body">
              <h4>지역</h4>
              <select v-model="selectedArea" @change="showLocationOption()">
                <option value="0" selected>전체</option>
                <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
              </select>
              <select v-model="selectedLocation" v-if="locationList.length > 1">
                <option value="0" selected>전체</option>
                <option :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{ item.location_nm }}</option>
              </select>
              <hr>
              <h4>날짜선택</h4>
              <Datepicker v-model="date" range multiCalendars :multiStatic="false" :enableTimePicker="false" />
              <hr>
              <h4>인원 수</h4>
              <label for="two">2</label>
              <input type="radio" v-model="filter.f_people" id="two" name="people" value="2">
              <label for="three">3</label>
              <input type="radio" v-model="filter.f_people" id="three" name="people" value="3">
              <label for="four">4</label>
              <input type="radio" v-model="filter.f_people" id="four" name="people" value="4">
              <label for="five">5</label>
              <input type="radio" v-model="filter.f_people" id="five" name="people" value="5">
              <label for="six">6</label>
              <input type="radio" v-model="filter.f_people" id="six" name="people" value="6">
              <label for="seven">7</label>
              <input type="radio" v-model="filter.f_people" id="seven" name="people" value="7">
              <label for="eight">8+</label>
              <input type="radio" v-model="filter.f_people" id="eight" name="people" value="8">
              <hr>
              <h4>성별</h4>
              <label for="M">남</label>
              <input type="radio" v-model="filter.f_gender" id="M" name="gender" value="1">
              <label for="F">여</label>
              <input type="radio" v-model="filter.f_gender" id="F" name="gender" value="2">
              <label for="X">혼성</label>
              <input type="radio" v-model="filter.f_gender" id="X" name="gender" value="3">
              <hr>
              <h4>연령대</h4>
              <div :key="item.idx" v-for="item in ageList">
                <label :for="item.idx">{{ item.age }}</label>
                <input type="radio" v-model="filter.f_age" :id="item.idx" :value="item.idx" name="age">
              </div>
              <hr>
              <h4>여행경비</h4>
              <div>
                <span>￦<input type="number" v-model="filter.l_price" step="1000" id="number" min="0"></span> - 
                <span>￦<input type="number" v-model="filter.h_price" step="1000" id="number" min="0"></span>
              </div>
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              <router-link :to="{ path: '/List' }">
                <button type="button" @click="moveToFilterList()">여행 찾기</button>
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
import { isThisHour, nextDay } from 'date-fns';

export default {
  components: {
    Datepicker
  },
  setup() {
    const date = ref();
    onMounted(() => {
      const startDate = new Date();
      const endDate = new Date(new Date().setDate(startDate.getDate()));
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
    this.getPrice();
  },
  methods: {
    async getAreaList() {
      this.areaList = await this.$get('/travel/areaList', {});
      console.log(this.areaList);
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
      };
    }
  }
}
</script>

<style>
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
  width: 600px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-footer {
  text-align: center;
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
  height: 500px;
  overflow-y: auto;
}
</style>
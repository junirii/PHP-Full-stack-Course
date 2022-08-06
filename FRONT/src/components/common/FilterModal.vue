<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header">필터</slot>
            <button @click="$emit('close')">X</button>
          </div>

          <div class="modal-body">
            <slot name="body">
              <h4>지역</h4>
              <select v-model="selectedArea" @change="showLocationOption()">
                <option value="" selected>전체</option>
                <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
              </select>
              <select v-model="selectedLocation" v-if="locationList.length > 1">
                <option value="" selected>전체</option>
                <option :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{ item.location_nm }}</option>
              </select>
              <hr>
              <h4>날짜선택</h4>

              <hr>
              <h4>인원 수</h4>
              <label for="two">2</label>
              <input type="radio" id="two" name="people" value="2">
              <label for="three">3</label>
              <input type="radio" id="three" name="people" value="3">
              <label for="four">4</label>
              <input type="radio" id="four" name="people" value="4">
              <label for="five">5</label>
              <input type="radio" id="five" name="people" value="5">
              <label for="six">6</label>
              <input type="radio" id="six" name="people" value="6">
              <label for="seven">7</label>
              <input type="radio" id="seven" name="people" value="7">
              <label for="eight">8+</label>
              <input type="radio" id="eight" name="people" value="8">
              <hr>
              <h4>성별</h4>
              <label for="M">남</label>
              <input type="radio" id="M" name="gender" value="1">
              <label for="F">여</label>
              <input type="radio" id="F" name="gender" value="2">
              <label for="X">혼성</label>
              <input type="radio" id="X" name="gender" value="3">
              <hr>
              <h4>연령대</h4>
              <div :key="item.idx" v-for="(item, i) in ageList">
                <label :for="item.idx">{{ item.age }}</label>
                <input type="radio" :id="item.idx" :value="item.idx">
              </div>
              <!-- <select>
                <option :key="item.idx" :value="item.idx" v-for="item in ageList">{{ item.age }}</option>
              </select> -->
              <hr>
              <h4>여행경비</h4>
              <input type="number" step="1000"> 원
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              default footer

              <button type="submit">확인</button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script>
export default {
  data() {
    return {
      areaList: [],
      locationList: [],
      ageList: [],
      selectedArea: '',
      selectedLocation: '',
    }
  },
  props: {
    show: Boolean
  },
  created() {
    this.getAreaList();
    this.getLocationList();
    this.getAgeList();
  },
  methods: {
    showLocationOption() {
      this.selectedLocation = '';
      this.locationList = [];
      this.getLocationList(this.selectedArea);
    },
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
  width: 500px;
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

.modal-login-button {
  display: inline-block;
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
.modal-content{
overflow-y: initial !important
}
.modal-body{
height: 500px;
overflow-y: auto;
}
</style>
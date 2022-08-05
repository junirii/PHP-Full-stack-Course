<template>
  <div class="create_box"></div>
  <h1>★일정★</h1>
  <div>
  <div>Day 1</div>
      <label for="ctntImg"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150" style="cursor:pointer"></label>
      <input class="d-none" type="file" id="ctntImg">
      <textarea name="" id="" cols="20" rows="4"></textarea>
  </div>

  <div>
      <!-- <button type="button" @click="newCal()">추가</button>
      <button type="button" @click="delCal()">삭제</button> -->
  </div>
  <hr>
  <div>
      <!-- <button type="button" class="btn btn-lg btn-danger" @click="travelInsert">등록</button> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      travel: {},
      travelDay: 0
    }
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      this.travel = this.$route.params.travel;
      this.travelDay = this.$route.params.travelDay;
      console.log(this.travel);
      console.log(this.travelDay);
    }
  }
}
</script>


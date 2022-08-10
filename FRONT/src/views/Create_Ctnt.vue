<template>
  <div class="create_box"></div>
  <h1>★일정★</h1>
  <div v-for="idx in travelDay">
    <div :id="`day${idx}`">Day {{idx}}
      <div id="ctntBox1">
        <label :for="`ctntImgDay${idx}_1`"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150" style="cursor:pointer"></label>
        <input type="file" class="d-none" :id="`ctntImgDay${idx}_1`" @change="addCtntImg($event, idx, 1)">
        <textarea name="" :id="`txtAreaDay${idx}_1`" cols="20" rows="4" v-model="ctntArr[idx-1][0].ctnt"></textarea>
      </div>
    </div>
    <div>
      <button type="button" @click="addCtnt(idx)">내용 추가</button>
      <button type="button" @click="delCtnt(idx)">내용 삭제</button>
    </div>
    <hr>
  </div>

  <div>
      <!-- <button type="button" @click="newCal()">추가</button>
      <button type="button" @click="delCal()">삭제</button> -->
  </div>
  <div>
      <button type="button" class="btn btn-lg btn-danger" @click="insTravel">등록</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      travelDay: 0,
      ctntArr: [],
      countArr: []
    }
  },
  created() {
    this.getData();
  },
  methods: {
    async addCtntImg(e, dayIdx, seq) {
      const files = e.target.files;
      const image = await this.$base64(files[0]);
      this.ctntArr[dayIdx-1][seq-1].img = image;
      console.log(this.ctntArr);
    },
    getData() { 
      this.travelDay = this.$store.state.travelDay;
      for(var i=0; i<this.travelDay; i++){
        this.ctntArr.push([{
          day: i + 1,
          seq: 1,
          ctnt: null,
          img: null,
        }]);
      }
      console.log(this.$store.state.travel);
    },
    addCtnt(idx){
      for(var i=0; i<this.travelDay; i++){
         this.countArr.push(2);
      }
      const seq = this.countArr[idx-1];
      const divDay = document.querySelector(`#day${idx}`);
      const ctntBox = divDay.appendChild(document.createElement('div'));
      ctntBox.innerHTML = `<label for="ctntImgDay${idx}_${seq}"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150" style="cursor:pointer"></label><input class="d-none" id="ctntImgDay${idx}_${seq}" type="file"><textarea name="" id="txtAreaDay${idx}_${seq}" cols="20" rows="4"></textarea>`;
      ctntBox.id = `ctntBox${seq}`;
      const inputImg = document.querySelector(`#ctntImgDay${idx}_${seq}`);
      inputImg.addEventListener('change', async (e) => {
        const files = e.target.files;
        const image = await this.$base64(files[0]);
        this.ctntArr[idx-1][seq-1].img = image;
        console.log(this.ctntArr);
      });

      this.ctntArr[idx-1].push({
        day: idx,
        seq: this.countArr[idx-1],
        ctnt: null,
        img: null,
      });
      this.countArr[idx-1]++;

      //추가된 txtArea v-model 추가
      // const txtArea = document.querySelector(`#txtAreaDay${idx}_${seq}`);
      // txtArea.setAttribute('v-model', this.ctntArr[idx-1][seq-1].ctnt);
      // console.log(this.ctntArr);

      // const test = new Vue({
      //   el: `#txtAreaDay${idx}_${seq}`,
      //   data: {ctnt: this.ctntArr[idx-1][seq-1].ctnt}
      // });
    },
    delCtnt(idx){
      const divDay = document.querySelector(`#day${idx}`);
      divDay.removeChild(divDay.lastChild);
      this.countArr[idx-1]--;
    },
    async insTravel(){   
      for(var i=0; i<this.ctntArr.length; i++){
        for(var z=0; z<this.ctntArr[i].length; z++){
          const txtArea = document.querySelector(`#txtAreaDay${i+1}_${z+1}`);
          this.ctntArr[i][z].ctnt = txtArea.value;
        }
      }
      const res = await this.$post('/travel/insTravelAndCtnt', {
        travel: this.$store.state.travel,
        ctnt: this.ctntArr
      });
      console.log(`res: ${res}`);
      if(res.result){
        const makeChat = await this.$post(`/chat/insChatRoom`, {
          itravel: res.result,
          iuser: this.$store.state.user.iuser
        });
        console.log(`makeChat: ${makeChat}`)
        if(makeChat.result){
          this.$store.state.unreadCnt[res.result] = 0;
          console.log(this.$store.state.unreadCnt);
          this.$swal.fire('글 작성 성공', '', 'success')
          .then(async result => {
              if(result.isConfirmed){
                  this.$store.state.itravel = res.result;
                  this.$router.push({name: 'detail'});
              }
          });
        }
      }
    }
  }
}
</script>


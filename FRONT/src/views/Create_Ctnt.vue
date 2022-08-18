<template>
  <div class="create-ctnt-box">
    <h1>상세일정</h1>
    <div v-for="idx in travelDay">Day {{ idx }}
      <div :id="`day${idx}`">
        <div class="create-ctnt-container" id="ctntBox1">
          <div v-if="!ismod">
            <label :id="`plus${idx}_1`" :for="`ctntImgDay${idx}_1`">
              <img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150"
                style="cursor:pointer">
            </label>
          </div>
          <div v-if="ismod">
            <label :id="`plus${idx}_1`" :for="`ctntImgDay${idx}_1`">
              <img :src="`/static/img/travel/${itravel}/detail/${ctntArr[idx - 1][0].img}`" width="150" height="150"
                style="cursor:pointer">
            </label>
          </div>
          <input type="file" class="d-none" :id="`ctntImgDay${idx}_1`"
            @change="addCtntImg($event, idx, 1), setThumbnail($event, idx, 1)">
          <div :id="`image_container${idx}_1`"></div>
          <textarea class="create-ctnt" name="" :id="`txtAreaDay${idx}_1`" cols="20" rows="4"
            v-model="ctntArr[idx - 1][0].ctnt"></textarea>
        </div>
      </div>
      <div>
        <button class="create-ctnt-btn" type="button" @click="addCtnt(idx)">내용 추가</button>
        <button class="create-ctnt-btn" type="button" @click="delCtnt(idx)">내용 삭제</button>
      </div>
      <hr>
    </div>
    <div>
      <!-- <button type="button" @click="newCal()">추가</button>
      <button type="button" @click="delCal()">삭제</button> -->
    </div>
    <div v-if="!ismod">
      <button type="button" class="btn btn-lg btn-danger create-ctnt-submit" @click="insTravel">등록</button>
    </div>
    <div v-if="ismod">
      <button type="button" class="btn btn-lg btn-danger create-ctnt-submit" @click="updTravel">수정</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      travelDay: 0,
      ctntArr: [],
      countArr: [],
      itravel: null,
      ismod: false
    }
  },
  created() {
    this.getData();
  },
  methods: {
    async updTravel() {
      for (var i = 0; i < this.ctntArr.length; i++) {
        for (var z = 0; z < this.ctntArr[i].length; z++) {
          const txtArea = document.querySelector(`#txtAreaDay${i + 1}_${z + 1}`);
          this.ctntArr[i][z].ctnt = txtArea.value;
        }
      }
      console.log(this.$store.state.travel);
      console.log(this.ctntArr);
      const res = await this.$put('/travel/updTravelAndCtnt', {
        travel: this.$store.state.travel,
        ctnt: this.ctntArr,
        itravel: this.itravel
      });
      console.log(res);
      if (res.result == 1) {
        this.$swal.fire('글 수정 성공', '', 'success')
          .then(async result => {
            if (result.isConfirmed) {
              this.$router.push({ name: 'detail' });
            }
          });
      }

    },
    setThumbnail(event, day, seq) {
      var reader = new FileReader();

      reader.onload = function (event) {
        var img = document.createElement("img");
        img.setAttribute("src", event.target.result);
        document.querySelector(`#image_container${day}_${seq}`).appendChild(img);
        img.style.height = "15vh";
        img.style.marginRight = "10px";
      };

      reader.readAsDataURL(event.target.files[0]);

      const plusBtn = document.querySelector(`#plus${day}_${seq}`);
      plusBtn.style.display = "none";
    },
    async addCtntImg(e, dayIdx, seq) {
      const files = e.target.files;
      const image = await this.$base64(files[0]);
      this.ctntArr[dayIdx - 1][seq - 1].img = image;
      console.log(this.ctntArr);
    },
    getData() {
      this.itravel = this.$store.state.mod.travelData.itravel;
      this.travelDay = this.$store.state.travelDay;
      for (var i = 0; i < this.travelDay; i++) {
        this.countArr[i] = 1;
      }
      if (this.$route.params.mod) {
        this.ismod = true;
        const modCtntArr = this.$store.state.mod.ctnt;
        for (var i = 0; i < this.travelDay; i++) {
          this.ctntArr.push([]);
        }
        modCtntArr.forEach(item => {
          const ctntObj = {
            day: item.day,
            seq: item.seq,
            ctnt: item.ctnt,
            img: item.img
          };
          this.ctntArr[parseInt(item.day) - 1].push(ctntObj);
        });
        console.log(this.ctntArr);
        this.ctntArr.forEach(item => {
          for (var i = 1; i < item.length; i++) {
            this.addCtnt(item[i].day);
            const txtArea = document.querySelector(`#txtAreaDay${item[i].day}_${i + 1}`);
            // txtArea.innerText = this.ctntArr[i-1][i].ctnt;
          }
        });
      } else {
        for (var i = 0; i < this.travelDay; i++) {
          this.ctntArr.push([{
            day: i + 1,
            seq: 1,
            ctnt: null,
            img: null,
          }]);
        }
      }
    },
    addCtnt(idx) {
      let seq = ++this.countArr[idx - 1];
      // if(this.$route.params.mod && this.ctntArr[idx-1][seq-1]){
      //   seq = ++this.countArr[idx - 1];
      // }
      console.log(`seq : ${seq}`);
      setTimeout(() => {
        const divDay = document.querySelector(`#day${idx}`);
        const ctntBox = divDay.appendChild(document.createElement('div'));
        // ctntBox.innerHTML = `<label :id="plus${idx}_${seq}" for="ctntImgDay${idx}_${seq}"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150" style="cursor:pointer"></label><input class="d-none" id="ctntImgDay${idx}_${seq}" type="file"><span :id="image_container${idx}_${seq}"></span><textarea class="create-ctnt" name="" id="txtAreaDay${idx}_${seq}" cols="20" rows="4"></textarea>`;
        if (this.$route.params.mod && this.ctntArr[idx - 1][seq - 1]) {
          ctntBox.innerHTML = `<label :id="plus${idx}_${seq}" for="ctntImgDay${idx}_${seq}"><img id="previewImg${idx}_${seq}" width="150" height="150" style="cursor:pointer"></label><input class="d-none" id="ctntImgDay${idx}_${seq}" type="file"><span :id="image_container${idx}_${seq}"></span><textarea class="create-ctnt" name="" id="txtAreaDay${idx}_${seq}" cols="20" rows="4"></textarea>`;
          const previewImg = document.querySelector(`#previewImg${idx}_${seq}`);
          previewImg.src = `/static/img/travel/${this.itravel}/detail/${this.ctntArr[idx - 1][seq - 1].img}`;
        } else {
          ctntBox.innerHTML = `<label :id="plus${idx}_${seq}" for="ctntImgDay${idx}_${seq}"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150" style="cursor:pointer"></label><input class="d-none" id="ctntImgDay${idx}_${seq}" type="file"><span :id="image_container${idx}_${seq}"></span><textarea class="create-ctnt" name="" id="txtAreaDay${idx}_${seq}" cols="20" rows="4"></textarea>`;
        }
        const inputFile = ctntBox.querySelector('input');
        const imgContainer = ctntBox.querySelector(`span`);
        const plusBtn = ctntBox.querySelector(`label`);
        inputFile.addEventListener('change', async function (e) {
          //setThumbnail()
          var reader = new FileReader();
          reader.onload = function (e) {
            var img = document.createElement("img");
            img.setAttribute("src", e.target.result);
            imgContainer.appendChild(img);
            img.style.height = "15vh";
            img.style.marginRight = "10px";
          };
          reader.readAsDataURL(e.target.files[0]);
          plusBtn.style.display = "none";

          //addCtntImg()
          const files = e.target.files;
          const image = await this.$base64(files[0]);
          this.ctntArr[idx - 1][seq - 1].img = image;
          console.log(this.ctntArr);
        });
        ctntBox.id = `ctntBox${seq}`;

        const textarea = document.querySelector(`#txtAreaDay${idx}_${seq}`);
        textarea.style.width = "40vw";
        textarea.style.height = "15vh";
        textarea.style.padding = "10px";

        if (this.$route.params.mod && this.ctntArr[idx - 1][seq - 1]) {
          textarea.innerText = this.ctntArr[idx - 1][seq - 1].ctnt;
        }


        const submitBtn = document.querySelector('.create-ctnt-submit');
        submitBtn.style.marginBottom = "150px";

        const inputImg = document.querySelector(`#ctntImgDay${idx}_${seq}`);
        inputImg.addEventListener('change', async (e) => {
          const files = e.target.files;
          const image = await this.$base64(files[0]);
          this.ctntArr[idx - 1][seq - 1].img = image;
          console.log(this.ctntArr);
        });
        if (!this.$route.params.mod) {
          this.ctntArr[idx - 1].push({
            day: idx,
            seq: this.countArr[idx - 1],
            ctnt: null,
            img: null,
          });
        }
        this.countArr[idx - 1]++;
        console.log(this.countArr);

        //추가된 txtArea v-model 추가
        // const txtArea = document.querySelector(`#txtAreaDay${idx}_${seq}`);
        // txtArea.setAttribute('v-model', this.ctntArr[idx-1][seq-1].ctnt);
        // console.log(this.ctntArr);

        // const test = new Vue({
        //   el: `#txtAreaDay${idx}_${seq}`,
        //   data: {ctnt: this.ctntArr[idx-1][seq-1].ctnt}
        // });
      }, 10);
    },
    delCtnt(idx) {
      const divDay = document.querySelector(`#day${idx}`);
      divDay.removeChild(divDay.lastChild);
      this.countArr[idx - 1]--;
    },
    async insTravel() {
      for (var i = 0; i < this.ctntArr.length; i++) {
        for (var z = 0; z < this.ctntArr[i].length; z++) {
          const txtArea = document.querySelector(`#txtAreaDay${i + 1}_${z + 1}`);
          this.ctntArr[i][z].ctnt = txtArea.value;
        }
      }
      const res = await this.$post('/travel/insTravelAndCtnt', {
        travel: this.$store.state.travel,
        ctnt: this.ctntArr
      });
      console.log(`res: ${res}`);
      if (res.result) {
        const makeChat = await this.$post(`/chat/insChatRoom`, {
          itravel: res.result,
          iuser: this.$store.state.user.iuser
        });
        console.log(makeChat);
        if (makeChat.result) {
          const resMsg = await this.$post('/chat/insChatMsg', {
            itravel: res.result,
            iuser: 0,
            msg: `채팅방이 개설되었습니다.`
          });
          console.log(resMsg);
          if (resMsg.result) {
            this.$store.state.unreadCnt[res.result] = 0;
            console.log(this.$store.state.unreadCnt);
            this.$swal.fire('글 작성 성공', '', 'success')
              .then(async result => {
                if (result.isConfirmed) {
                  this.$store.state.itravel = res.result;
                  this.$router.push({ name: 'detail' });
                }
              });
          }
        }
      }
    }
  }
}

</script>

<style scoped>
.create-ctnt-box {
  z-index: auto;
  margin: 0 auto;
  padding-top: 100px;
  color: var(--maincolor);
}

.create-ctnt-container {
  display: flex;
  justify-content: center;
}

.create-ctnt {
  padding: 10px;
  width: 40vw;
  height: 15vh;
  display: flex;
  flex-direction: row;
}

.create-ctnt-btn {
  background-color: var(--maincolor);
  color: #fff;
  border: 0;
  padding: 5px;
  margin: 5px;
}

.create-ctnt-submit {
  margin-bottom: 110px;
}
</style>
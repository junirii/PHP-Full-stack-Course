<template>
    <div class="create-box">
        <div class="create-section">
            <div class="thumb">
                <div>썸네일 사진</div>
                <div v-if="files.length === 0">
                    <label for="file"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="250"
                            height="250" style="cursor:pointer" class="plus" id="image" @change="test($event)"></label>
                    <input class="d-none" type="file" accept="img/png,img/jpeg" id="file" ref="files"
                        @change="addMainImg($event.target.files), test($event)">
                </div>
                <div v-for="(file, index) in files" :key="index">
                    <div @click="imgDeleteButton" :name="file.number">x</div>
                    <img :src="file.preview" width="200" height="200"/>
                </div>
            </div>
            <div class="travel-create">
                <div>
                    <span class="section-title">글 제목</span>
                    <input class="title-input font bolder" type="text" placeholder="제목을 입력하세요." v-model="travel.title">
                </div>
                <div class="area-section">
                    <span class="section-title">지역</span>
                    <select class="bolder" v-model="travel.area" @change="showLocationOption()">
                        <option class="bolder" value="" selected>전체</option>
                        <option class="bolder" :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
                    </select>
                    <select class="bolder" v-model="travel.location" v-if="locationList.length > 1">
                        <option value="0" selected>전체</option>
                        <option class="bolder" :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">
                            {{ item.location_nm }}
                        </option>
                    </select>
                </div>
                <div>
                    <span class="section-title">성별</span>
                    <select class="bolder" v-model="travel.f_gender">
                        <option class="bolder" value="" selected>선택</option>
                        <option :key="item.idx" :value="item.idx" v-for="item in genderList">{{ item.nm }}</option>
                    </select>
                </div>
                <div>
                    <span class="section-title">정원</span>
                    <input type="number" min="2" placeholder="인원수" v-model="travel.f_people"> 명
                </div>
                <div>
                    <span class="section-title">예상 비용</span>
                    <input class="price-input" type="number" min="0" v-model="travel.f_price" step="10000"> 원
                </div>
                <div>
                    <span class="section-title">연령대</span>
                    <select class="bolder" v-model="travel.f_age">
                        <option class="bolder" value="" selected>선택</option>
                        <option :key="item.idx" :value="item.idx" v-for="item in ageList">{{ item.age }}</option>
                    </select>
                </div>
                <div>
                    <span class="section-title">날짜</span>
                    <input class="date-input" type="date" v-model="travel.s_date"> ~ <input class="date-input" type="date" v-model="travel.e_date" @change="test">
                </div>
            </div>
        </div>
            <div class="btn-section">
            <button class="btn next-btn2" type="button" @click="goToCreateCtnt">다음</button>
            </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            travel: {
                iuser: this.$store.state.user.iuser,
                title: '',
                f_gender: 0,
                f_price: 0,
                f_people: 0,
                f_age: 0,
                area: 0,
                location: null,
                s_date: new Date().toISOString().substring(0, 10),
                e_date: '',
                main_img: null
            },
            areaList: [],
            locationList: [],
            ageList: [],
            genderList: [],
            showLocationSelect: false,
            files: [],
            filesPreview: [],
            uploadImageIndex: 0,
        }
    },
    created() {
        this.getAreaList();
        this.getLocationList();
        this.getAgeList();
        this.setModPage();
        this.getGenderList();
        // this.getPeopleList();
    },
    methods: {
        setModPage(){
            if(this.$route.params.mod){
                const travelData = this.$store.state.mod.travelData;
                this.travel.iuser = travelData.iuser;
                this.travel.title = travelData.title;
                this.travel.f_gender = travelData.f_gender;
                this.travel.f_price = travelData.f_price;
                this.travel.f_people = travelData.f_people;
                this.travel.f_age = travelData.f_age;
                this.travel.area = travelData.area;
                this.travel.location = travelData.location;
                this.travel.s_date = travelData.s_date;
                this.travel.e_date = travelData.e_date;
                this.travel.main_img = travelData.main_img;
            }
        },
        goToCreateCtnt() {
            if (!(this.travel.title)) {
                alert('제목을 입력해 주세요.');
            } else if (!(this.travel.area)) {
                alert('지역을 입력해 주세요.');
            } else if (!(this.travel.f_gender)) {
                alert('성별을 입력해 주세요.');
            } else if (!(this.travel.f_people)) {
                alert('인원을 입력해 주세요.');
            } else if (!(this.travel.f_price)) {
                alert('비용을 입력해 주세요.');
            } else if (!(this.travel.f_age)) {
                alert('연령대를 입력해 주세요.');
            } else if (!(this.travel.s_date && this.travel.e_date)) {
                alert('날짜를 입력해 주세요.');
            } else {
                const s_date = new Date(this.travel.s_date);
                const e_date = new Date(this.travel.e_date);
                const gap = e_date.getTime() - s_date.getTime();

                this.$store.state.travel = this.travel;
                this.$store.state.travelDay = gap / (1000*60*60*24) + 1;

                if(this.$route.params.mod){
                    this.$router.push({name: 'create_ctnt', params: {mod: 1}});
                }else{
                    this.$router.push({name: 'create_ctnt'});
                }
            }
        },
        currentDate() {
            document.getElementById('currentDate').value = new Date().toISOString().substring(0, 10);
        },
        async getAreaList() {
            this.areaList = await this.$get('/travel/areaList', {});
        },
        async getLocationList(iarea) {
            this.locationList = await this.$get(`/travel/locationList/${iarea}`, {});
        },
        async getGenderList() {
            this.genderList = await this.$get('/travel/genderList', {});
        },
        async getAgeList() {
            this.ageList = await this.$get('/travel/ageList', {});
        },
        async getPeopleList() {
            this.peopleList = await this.$get('/travel/peopleList', {});
        },
        showLocationOption() {
            this.travel.location = null;
            this.locationList = [];
            this.getLocationList(this.travel.area);
        },
        showAgeOption() {
            this.travel.age = null;
            this.ageList = [];
            this.getAgeList(this.travel.iage);
        },
        async travelInsert() {
            const inputFile = document.querySelector('#file');
            console.log(inputFile.files[0].name);
            this.travel.main_img = inputFile.files[0].name;
            // if (this.selectedLocation) {
            //     this.travel.location = this.selectedLocation;
            // } else {
            //     this.travel.location = 0;
            // }
            const result = this.$post('/travel/create', this.travel);
            console.log(result);
            this.$swal.fire('글작성 성공!', '', 'success');
        },
        async addMainImg(files) {
            console.log(files);
            const image = await this.$base64(files[0]);
            this.travel.main_img = image;
            console.log(this.travel);
            // const { error } = await this.$post('/travel/uploadMainImg', formData);
            // console.log(error);

            //현민 코드
            // // this.files = [...this.files, this.$refs.files.files];
            // //하나의 배열로 넣기
            // let num = -1;
            // for (let i = 0; i < this.$refs.files.files.length; i++) {
            //     this.files = [
            //         ...this.files,
            //         //이미지 업로드
            //         {
            //             //실제 파일
            //             file: this.$refs.files.files[i],
            //             //이미지 프리뷰
            //             preview: URL.createObjectURL(this.$refs.files.files[i]),
            //             //삭제및 관리를 위한 number
            //             number: i
            //         }
            //     ];
            //     num = i;
            //     this.filesPreview = [
            //       ...this.filesPreview,
            //       { file: URL.createObjectURL(this.$refs.files.files[i]), number: i }
            //     ];
            // }
            // this.uploadImageIndex = num + 1; //이미지 index의 마지막 값 + 1 저장
            // console.log(this.files);
            // // console.log(this.filesPreview);
        },
        imgDeleteButton(e) {
            const name = e.target.getAttribute('name');
            this.files = this.files.filter(data => data.number !== Number(name));
        },
        newCal() {

        },
        test(event) {
        var reader = new FileReader();

        reader.onload = function (e) {
        document.getElementById("image").src = e.target.result;
        var img = document.createElement("img");
        img.setAttribute("src", event.target.result);
      }
        reader.readAsDataURL(event.target.files[0]);
        },
    }
}

</script>

<style scoped>
.create-box {
    z-index: auto;
    margin: 0 auto;
    padding: 150px !important;
    width: 70%;
    display: flex;
    flex-direction: column;
}
.create-section {
    text-align: left;
    display: inline-flex;
    flex-direction: row;
    color: var(--maincolor);
    flex-wrap: wrap;
}
.create-section > select, option, input {
    font-weight: bolder;
} 
.thumb {
    text-align: center;
    padding-right: 3vw;
}
.travel-create {
    padding-right: 10vw;
}
.section-title{
    padding-right: 20px;
    display: inline-block;
    text-align: right;
    width: 8vw;
    padding-bottom: 10px;
}
/* .create-box > div {
    padding-bottom: 10px;
} */
.title-input {
    width: 15vw;
}
.title-input:hover {
    border-bottom: 2px solid var(--mainDark);
}
/* .area-section {
    
} */
.price-input {
    width: 7vw;
}
.date-input {
    width: 9vw;
}
select, input {
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
select:hover, input:hover { border-bottom: 2px solid var(--mainDark) }
select::-ms-expand { display: none; }
select:focus { 
    border: 2px solid var(--mainDark);
    /* border-radius: 10px; */
}
.btn-section {
    display: flex;
    justify-content: center;
}
.next-btn2 {
    display: flex;
    justify-items: center;
    align-items: center;
    width: 30px !important;
}
</style>
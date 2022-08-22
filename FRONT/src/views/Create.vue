<template>
    <div class="create-box">
        <h1 class="bolder">여행 호스팅 하기</h1>
        <div class="create-section">
            <div class="thumb">
                <div v-if="files.length === 0">
                    <div v-if="!travel.main_img">
                        <label for="file"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="250"
                                height="250" style="cursor:pointer" class="plus" id="image"></label>
                    </div>
                    <div v-if="travel.main_img">
                        <label for="file"><img :src="`/static/img/travel/${itravel}/main/${travel.main_img}`" width="250"
                                height="250" style="cursor:pointer; object-fit:cover;" class="plus" id="image"></label>
                    </div>
                    <input class="d-none" type="file" accept="img/png,img/jpeg" id="file" ref="files"
                        @change="addMainImg($event.target.files), previewImg($event)">
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
                        <option :key="item.idx" :value="item.idx" v-for="item in genderList">{{ item.gender }}</option>
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
            itravel: null
        }
    },
    created() {
        this.getAreaList();
        this.getLocationList();
        this.getAgeList();
        this.setModPage();
        this.getGenderList();
    },
    methods: {
        setModPage(){
            if(this.$route.params.mod){
                const travelData = this.$store.state.mod.travelData;
                this.itravel = travelData.itravel;
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
                this.$swal.fire('제목을 입력해 주세요.', '', 'error');
            } else if (!(this.travel.area)) {
                this.$swal.fire('지역을 입력해 주세요.', '', 'error');
            } else if (!(this.travel.f_gender)) {
                this.$swal.fire('성별을 입력해 주세요.', '', 'error');
            } else if (!(this.travel.f_people)) {
                        this.$swal.fire('인원을 입력해 주세요.', '', 'error');
            } else if (!(this.travel.f_price)) {
                        this.$swal.fire('비용을 입력해 주세요.', '', 'error');
            } else if (!(this.travel.f_age)) {
                        this.$swal.fire('연령대를 입력해 주세요.', '', 'error');
            } else if (!(this.travel.s_date && this.travel.e_date)) {
                        this.$swal.fire('날짜를 입력해 주세요.', '', 'error');
            } else if (!(this.travel.main_img)) {
                        this.$swal.fire('썸네일을 등록해 주세요.', '', 'error');
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
            this.travel.main_img = inputFile.files[0].name;
            const result = this.$post('/travel/create', this.travel);
            this.$swal.fire('글작성 성공!', '', 'success');
        },
        async addMainImg(files) {
            const image = await this.$base64(files[0]);
            this.travel.main_img = image;
        },
        imgDeleteButton(e) {
            const name = e.target.getAttribute('name');
            this.files = this.files.filter(data => data.number !== Number(name));
        },
        newCal() {

        },
        previewImg(event) { // 이미지 미리보기
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
h1 { 
    color: var(--maincolor);
    padding-bottom: 50px;
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
    font-size: 1.2rem;
}
.title-input {
    width: 15vw;
}
.title-input:hover {
    border-bottom: 2px solid var(--mainDark);
}

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
    height: 30px;
    padding-left: 10px;
    color: var(--maincolor);
}
select:hover, input:hover {
    border-bottom: 2px solid var(--mainDark);
    cursor: pointer;    
}
select::-ms-expand { display: none; }
select:focus, input:focus {
    outline: none;
    border: 2px solid var(--mainDark);
}
.btn-section {
    padding-top: 50px;
    display: flex;
    justify-content: center;
}
.next-btn2 {
    display: flex;
    justify-items: center;
    align-items: center;
    width: 100px !important;
}
</style>
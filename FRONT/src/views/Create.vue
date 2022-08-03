<template>
    <div class="create_box">
        <div>
            <span>글 제목</span>
            <input type="text" placeholder="제목" v-model="travel.title">
        </div>
        <div>
            <span>지역</span>
            <select v-model="selectedArea" @change="showLocationOption()">
                <option value="" selected>전체</option>
                <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
            </select>
            <select v-model="selectedLocation" v-if="locationList.length > 1">
                <option value="" selected>전체</option>
                <option :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{ item.location_nm
                }}
                </option>
            </select>
        </div>
        <div>
            <span>성별</span>
            <select v-model="travel.f_gender">
                <option value="1">남</option>
                <option value="2">여</option>
                <option value="3">혼성</option>
            </select>
        </div>
        <div>
            <span>인원수</span>
            <input type="number" min="0" placeholder="인원수" v-model="travel.f_people">
        </div>
        <div>
            <span>비용</span>
            <select v-model="travel.f_price">
                <option value="1">0~5만원</option>
                <option value="2">5~10만원</option>
                <option value="3">10~20만원</option>
                <option value="4">20~30만원</option>
                <option value="5">30~40만원</option>
                <option value="6">40~50만원</option>
                <option value="7">50만원 이상</option>
            </select>
        </div>
        <div>
            <span>연령대</span>
            <select v-model="travel.f_age">
                <option :key="item.idx" :value="item.idx" v-for="item in ageList">{{ item.age }}</option>
            </select>
        </div>
        <div>
            <span>날짜</span>
            <input type="date" v-model="travel.s_date"> ~ <input type="date" v-model="travel.e_date">
        </div>
        <div>
            <span>사진등록</span>
            <img id="preview" @click="clickInputFile()" src="https://www.picng.com/upload/plus/png_plus_52132.png" width="160" height="160" style="cursor:pointer">
            <div class="d-none">
                <input id="inputImg" @change="readURL(this);" type="file" name="img" accept="image/*">
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-lg btn-danger" @click="travelInsert">저장</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            travel: {
                iuser: 0,
                title: '',
                f_gender: 0,
                f_price: 0,
                f_people: 0,
                f_age: 0,
                area: 0,
                location: 0,
                s_date: '',
                e_date: '',
                main_img: ''
            },
            areaList: [],
            locationList: [],
            ageList: [],
            showLocationSelect: false,
            selectedArea: '',
            selectedLocation: '',
        }
    },
    created() {
        this.getAreaList();
        this.getLocationList();
        this.getAgeList();
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
        async travelInsert() {
            const inputFile = document.querySelector('#inputImg');
            console.log(inputFile.files[0].name);
            this.travel.main_img = inputFile.files[0].name;
            this.travel.area = this.selectedArea;
            this.travel.iuser = this.$store.state.user.iuser;
            if (this.selectedLocation) {
                this.travel.location = this.selectedLocation;
            } else {
                this.travel.location = 0;
            }
            const result = this.$post('/travel/create', this.travel);
            console.log(result);
            this.$swal.fire('글작성 성공!', '', 'success');
        },
        clickInputFile() {
            const input = document.querySelector('#inputImg');
            input.click();
        },
        readURL(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = "";
            }
        }
    }
}

</script>

<style>
.create_box {
    z-index: auto;
    margin: 0 auto;
    padding: 150px;
}
</style>
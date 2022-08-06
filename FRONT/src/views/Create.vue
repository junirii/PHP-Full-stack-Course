<template>
    <div class="create_box">
        <div>
            <span>글 제목</span>
            <input type="text" placeholder="제목" v-model="travel.title">
        </div>
        <div>
            <span>지역</span>
            <select v-model="travel.area" @change="showLocationOption()">
                <option value="" selected>전체</option>
                <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
            </select>
            <select v-model="travel.location" v-if="locationList.length > 1">
                <option value="0" selected>전체</option>
                <option :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{ item.location_nm }}</option>
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
            <span>정원</span>
            <input type="number" min="2" placeholder="인원수" v-model="travel.f_people"> 명
        </div>
        <div>
            <span>예상 비용</span>
            <input type="number" v-model="travel.f_price" step="1000"> 원
        </div>
        <div>
            <span>연령대</span>
            <select v-model="travel.f_age">
                <option :key="item.idx" :value="item.idx" v-for="item in ageList">{{ item.age }}</option>
            </select>
        </div>
        <div>
            <span>날짜</span>
            <input type="date" v-model="travel.s_date"> ~ <input type="date" v-model="travel.e_date" @change="test">
        </div>
        <div>썸네일 사진</div>
        <div v-if="files.length === 0">
            <label for="file"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150" height="150" style="cursor:pointer"></label>
            <input class="d-none" type="file" accept="img/png,img/jpeg" id="file" ref="files" @change="addMainImg($event.target.files)">
        </div>
        <div v-for="(file, index) in files" :key="index">
            <div @click="imgDeleteButton" :name="file.number">x</div>
            <img :src="file.preview" width="200" height="200"/>
        </div>
        <button type="button" @click="goToCreateCtnt">다음</button>
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
                f_people: 2,
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
    },
    methods: {
        goToCreateCtnt(){
            const s_date = new Date(this.travel.s_date);
            const e_date = new Date(this.travel.e_date);
            const gap = e_date.getTime() - s_date.getTime();

            this.$store.state.travel = this.travel;
            this.$store.state.travelDay = gap / (1000*60*60*24) + 1;
            this.$router.push({name: 'create_ctnt'});
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
        async getAgeList() {
            this.ageList = await this.$get('/travel/ageList', {});
        },
        showLocationOption() {
            this.travel.location = null;
            this.locationList = [];
            this.getLocationList(this.travel.area);
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
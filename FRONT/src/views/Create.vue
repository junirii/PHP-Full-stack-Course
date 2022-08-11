<template>
    <div class="create-box">
        <div class="create-box-item create-box-title">
            <span class="create-box-item-title">글 제목</span>
            <input type="text" placeholder="제목을 입력해 주세요." v-model="travel.title">
        </div>
        <div class="create-box-item create-box-area-location">
            <span class="create-box-item-title">지역</span>
            <select v-model="travel.area" @change="showLocationOption()">
                <option value="" selected>전체</option>
                <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
            </select>
            <select v-model="travel.location" v-if="locationList.length > 1">
                <option value="0" selected>전체</option>
                <option :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{
                        item.location_nm
                }}</option>
            </select>
        </div>
        <div class="create-box-item create-box-gender">
            <span class="create-box-item-title">성별</span>
            <select v-model="travel.f_gender">
                <option value="1">남성</option>
                <option value="2">여성</option>
                <option value="3">혼성</option>
            </select>
        </div>
        <div class="create-box-item create-box-people">
            <span class="create-box-item-title">정원</span>
            <input type="number" min="2" placeholder="인원수" v-model="travel.f_people"> 명
        </div>
        <div class="create-box-item create-box-price">
            <span class="create-box-item-title">예상 비용</span>
            <input type="number" v-model="travel.f_price" step="1000"> 원
        </div>
        <div class="create-box-item create-box-age">
            <span class="create-box-item-title">연령대</span>
            <select v-model="travel.f_age">
                <option :key="item.idx" :value="item.idx" v-for="item in ageList">{{ item.age }}</option>
            </select>
        </div>
        <div class="create-box-item create-box-date">
            <span class="create-box-item-title">날짜</span>
            <input type="date" v-model="travel.s_date"> ~ <input type="date" v-model="travel.e_date" @change="test">
        </div>
        <div class="create-box-item create-box-thumbnail">
            <span class="create-box-item-title">썸네일 사진</span>
            <div v-if="files.length === 0">
                <label for="file"><img src="https://www.picng.com/upload/plus/png_plus_52132.png" width="150"
                        height="150" style="cursor:pointer"></label>
                <input class="d-none" type="file" accept="img/png,img/jpeg" id="file" ref="files"
                    @change="addMainImg($event.target.files)">
            </div>
            <div v-for="(file, index) in files" :key="index">
                <div @click="imgDeleteButton" :name="file.number">x</div>
                <img :src="file.preview" width="200" height="200" />
            </div>
            <button type="button" @click="goToCreateCtnt();">다음</button>
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
            this.$store.state.travelDay = gap / (1000 * 60 * 60 * 24) + 1;
            this.$router.push({ name: 'create_ctnt' });
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

<style scoped>
.create-box {
    z-index: auto;
    margin: 0 auto;
    padding: 150px;

    display: flex;
    flex-direction: column;
    align-items: flex-start;
    color: var(--maincolor);
}

.create-box-item {
    padding: 10px;
    height: 5vh;
}

.create-box-item-title {
    display: inline-block;
    text-align: left;
    width: 10vw;
}

input,
select {
    margin: 5px;
    border: 1px solid var(--maincolor);
    border-radius: 0%;
    padding: 5px;

}

/* 글제목 */
.create-box-title input {
    width: 40vw;
}
</style>
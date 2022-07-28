<template>
    <div>
        <span>글 제목</span>
        <input type="text" placeholder="제목" v-model="board.title">
    </div>
    <div>
        <span>지역</span>
        <select v-model="selectedArea" @change="showLocationOption()">
            <option value="" selected>전체</option>
            <option :key="item.iarea" :value="item.iarea" v-for="item in areaList">{{ item.area_nm }}</option>
        </select>
        <select v-model="selectedLocation" v-if="locationList.length > 1">
            <option value="0" selected>전체</option>
            <option :key="item.ilocation" :value="item.ilocation" v-for="item in locationList">{{ item.location_nm }}
            </option>
        </select>
    </div>
    <div>
        <span>성별</span>
        <select v-model="board.f_gender">
            <option value="1">남</option>
            <option value="2">여</option>
            <option value="3">혼성</option>
        </select>
    </div>
    <div>
        <span>인원수</span>
        <input type="number" min="0" placeholder="인원수" v-model="board.f_people">
    </div>
    <div>
        <span>비용</span>
        <select v-model="board.f_price">
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
        <select v-model="board.f_age">
            <option value="1">20~30대</option>
            <option value="2">30~40대</option>
            <option value="3">40~50대</option>
            <option value="4">제한없음</option>
        </select>
    </div>
    <div>
        <span>날짜</span>
        <input type="date" v-model="board.s_date"> ~ <input type="date" v-model="board.e_date">
    </div>
    <div>
        <span>사진등록</span>
        <img id="preview" @click="clickInputFile()" src="https://www.picng.com/upload/plus/png_plus_52132.png" width="160" height="160" style="cursor:pointer">
        <div class="d-none">
            <input id="inputImg" @change="readURL();" type="file" name="img" accept="image/*">
        </div>

        <!-- <div>
            <label for="file">사진 등록</label>
            <input type="file" id="file" ref="files" @change="imageUpload" v-on:change="inputImgFile" />
        </div>
        <div>
            <span>이미지</span>
            <div v-for="(file, index) in files" :key="index" class="file-preview-wrapper">
                <div class="file-close-button" @click="imgDeleteButton" :name="file.number">
                    X
                </div>
                <img :src="file.preview" />
            </div>
        </div> -->

    </div>
    <div>
        <button type="button" class="btn btn-lg btn-danger" @click="boardInsert">저장</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            board: {
                iuser: 1,
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
            showLocationSelect: false,
            selectedArea: '',
            selectedLocation: '',
            // previewImage: '',
            // files: [],
            // filesPreview: [],
            // uploadImageIndex: 0,
        }
    },
    created() {
        this.getAreaList();
        this.getLocationList();
    },
    methods: {
        async getAreaList() {
            this.areaList = await this.$get('/board/areaList', {});
            console.log(this.areaList);
        },
        async getLocationList(iarea) {
            this.locationList = await this.$get(`/board/locationList/${iarea}`, {});
            console.log(this.locationList);
        },
        showLocationOption() {
            this.selectedLocation = '';
            this.locationList = [];
            this.getLocationList(this.selectedArea);
        },
        async boardInsert() {
            const inputFile = document.querySelector('#file');
            console.log(inputFile.files[0].name);
            this.board.main_img = inputFile.files[0].name;
            this.board.area = this.selectedArea;
            if (this.selectedLocation) {
                this.board.location = this.selectedLocation;
            } else {
                this.board.location = 0;
            }
            const result = this.$post('/board/create', this.board);
            console.log(result);
            this.$swal.fire('글작성 성공!', '', 'success');
        },
        clickInputFile() {
            const preview = document.querySelector('#preview');
            const input = document.querySelector('#inputImg');
            preview.addEventListener('click', () => {
                input.click();
            })
        },
        readURL() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview').src = this.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                document.getElementById('preview').src = "";
            }
        }

        
        // imageUpload() {
        //     console.log(this.$refs.files.files);
        //     let num = -1;
        //     for (let i = 0; i < this.$refs.files.files.length; i++) {
        //         this.files = [
        //             ...this.files,
        //             //이미지 업로드
        //             {
        //                 //실제 파일
        //                 file: this.$refs.files.files[i],
        //                 //이미지 프리뷰
        //                 preview: URL.createObjectURL(this.$refs.files.files[i]),
        //                 //삭제및 관리를 위한 number
        //                 number: i
        //             }
        //         ];
        //         num = i;
        //     }
        //     this.uploadImageIndex = num + 1;
        //     console.log(this.files);
        // },
        // inputImgFile() {
        //     this.board.main_img = this.$refs.files.name;
        // },
    }
}

</script>

<style>
.create_box {
    margin: 0 auto;
    padding: 150px;
}
</style>
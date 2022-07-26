<template>
        <div>
            <span>글 제목</span>
            <input type="text" placeholder="제목" v-model="board.title">
        </div>
        <div>
            <span>지역</span>
            <select v-model="board.iarea">
                <option :key="iarea" v-for="(value, iarea) in areaList">{{ value.area_nm }}</option>
            </select>
            <select v-model="board.ilocation" v-if="showLocationSelect">
                <option :key="ilocation" v-for="(value, ilocation) in locationList">{{ value.location_nm }}</option>
            </select>
        </div>
        <div>
            <span>성별</span>
            <select v-model="board.gender">
                <option value="0">혼성</option>
                <option value="1">남</option>
                <option value="2">여</option>
            </select>
        </div>
        <div>
            <span>인원수</span>
            <input type="number" min="0" placeholder="인원수" v-model="board.people">
        </div>
        <div>
            <span>연령대</span>
            <select v-model="board.age">
                <option value="1">10대</option>
                <option value="2">20대</option>
                <option value="3">30대</option>
                <option value="4">40대</option>
                <option value="5">50대</option>
            </select>
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
                title: '',
                //gender: 0,
                //people: 0,
                //age: 0,
                iarea: 0,
                ilocation: 0,
                iuser: 1,
                s_date: "2020-02-02",
                e_date: "2020-02-03",
                main_img: "img"
            },
            areaList: [],
            locationList: [],
            showLocationSelect: true
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
        async getLocationList() {
            this.locationList = await this.$get('/board/locationList', {});
            console.log(this.locationList);
        },
        async boardInsert() {
            const result = this.$post('/board/boardInsert', this.board);
            console.log(result);
        }
    }
}
</script>

<style>
</style>
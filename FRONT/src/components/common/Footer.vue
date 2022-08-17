<template>
    <footer>
        <!-- class="mt-5 py-5" -->
        <div class="container">
            <div class="section-logo">
                <img class="footer-logo" src="../../../static/img_used/moim4.png" alt="푸터 로고">
            </div>
            <div class="section-team">
                <div>프로젝트명 : 프로젝트명</div>
                <div>팀명 : &copy;teamB</div>
                <div>팀원 : 남그린 김준일 조현민 김동휘 윤정인</div>
                <div>주소 : 대구 중구 중앙대로 394 제일빌딩 5F 그린컴퓨터 아트학원</div>
                <div>전화번호 : 053-572-1005</div>
            </div>
        </div>
    </footer>
</template>

<script>

export default {
    name: 'footer'
}
</script>

<style scoped>
footer {
    background-color: #fff;
    z-index: 0;
    position: absolute;
    bottom: 0;
    left: 80px;
    right: 0;
    width: 90%;
    border-top: 2px solid rgb(255, 136, 0);
    color: var(--maincolor);
    padding: 1rem;
    height: 110px;
}

.container {
    display: flex;
    justify-content: space-between;
}

.section-logo,
.section-team {
    text-align: right;
    font-size: 0.7rem;
    padding-bottom: 20px;
}
.footer-logo {
    padding-top: 30px;
    width: 200px;
}
</style>
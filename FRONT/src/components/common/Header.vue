<template>
    <header>
        <div class="header-box">
            <div class="logo-box">
                <router-link :to="{ path: '/' }">
                    <h2 class="logo">여행어쩌구</h2>
                </router-link>
            </div>
            <div class="icons">
                <div class="notifi">
                    <i class="fa-regular fa-bell fa-2x dropdown" @click="selRequest()"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <ul class="dropdown-menu">
                    <div>
                    <li class="dropdown-item" >ㅇㅇ</li>
                    <li class="dropdown-item" >Another action</li>
                    <li class="dropdown-item" >Something else here</li>
                    </div>
                </ul>
                </div>
                <div class="burger-wrapper">
                    <input type="checkbox" id="sideMenu">
                    <label id="burger" for="sideMenu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </label>
                    <nav id="menu">
                        <ul>
                            <li v-if="this.$store.state.isLogin" @click="changeFeedIuser">마이페이지</li>
                            <router-link :to="{ path: '/MyAccount' }">
                                <li v-if="this.$store.state.isLogin">회원정보 수정</li>
                            </router-link>
                            <li v-if="this.$store.state.isLogin">DM</li>
                            <router-link :to="{ path: '/Create' }">
                                <li v-if="this.$store.state.isLogin">여행 호스팅 하기</li>
                            </router-link>
                            <router-link :to="{ path: '/List' }">
                                <li v-if="this.$store.state.isLogin">전체 리스트</li>
                            </router-link>
                            <li v-if="this.$store.state.isLogin" @click="logout">로그아웃</li>
                            <li v-if="!this.$store.state.isLogin" @click="logout">로그인</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    
    data(){
        return {

        };
    },
    methods: {
        changeFeedIuser(){
            this.$store.state.feedIuser = this.$store.state.user.iuser;
            this.$router.push({name: 'mypage'});
        },
        async logout(){
            if(this.$store.state.isLogin === true){
                const res = await this.$post('/user/logout');
                if(res.result === 1){
                this.$store.commit('user', {});
                console.log(this.$store.state.user.iuser);
                this.$store.state.isLogin = false;
                this.$swal.fire('로그아웃되었습니다.', '', 'success')
                .then(async result => {
                    if(result.isConfirmed){
                        this.$router.push({name: 'home'});
                    }
                });
                }else{
                this.$swal.fire('로그아웃 실패', '', 'error');
                }
            }
        },
        loginCheck(){
            this.isLogin = this.$store.state.isLogin;
        },
        async selRequest() {

        }
    },
    created(){
        this.loginCheck();
    }
}
</script>

<style>

* {
    margin: 0;
}
html {
    font-size: 16px;
    font-family: 'LeferiPoint-WhiteA';
}
header {
    z-index: 1;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    /* max-width: 100%; */

    /* height: 100px; */
    padding: 1rem;
    color: white;
    font-weight: bold;
    align-items: center;
    background-color: #2d7ac2;
    text-decoration-line: none;

    border-bottom: 1px solid #eee;
    height: 5rem;
}
.header-box {
    display: flex;
    justify-content: space-between;
}
.logo-box {
    padding: 6px;
    display: flex;
    justify-content: space-between;
}
.logo {
    text-decoration-line: none;
    color: white;
}
.notifi {
    padding: 6px;
    display: flex;
    cursor: pointer;
    justify-content: center;
    align-items: center;
    position: relative;
    right: 65px;
    top: 3px;
}
.burger-wrap {
    cursor: pointer;
    padding: 6px;
}
#menu {
    background: white;
    width: 20rem;
    height: 100vh;
    position: fixed;
    right: 0;
    transition-timing-function: cubic-bezier(10,2,3,1);
    transform: translateX(50rem);
    top: 0;
    z-index: 0;
    transition: 0.5s;
    padding-top: 100px;
}
li {
    color: var(--mainDark);
    font-size: 1.2rem;
    /* display: inline-block; */
    /* position: relative; */
    cursor: pointer;
    /* z-index: 4; */
    transition: 0.3s;
    min-width: 120px;
    list-style: none;
    padding: 8px;
}
#sideMenu {
    display: none;
}
#sideMenu:checked ~ #menu {
    transform: translateX(0rem);
}
#burger {
    position: absolute;
    cursor: pointer;
    width: 2rem;
    height: 2rem;
    /* right: 1rem; */
    top: 1.5rem;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
}
#burger > div {
    height: 2px;
    background-color: white;
    transition: 0.5s;
    z-index: 999;
}
#sideMenu:checked ~ #burger > div {
    background-color: var(--mainDark);
}

#sideMenu:checked ~ #burger > div:nth-child(1) {
    transform: translateY(15px) rotate(45deg);
}
#sideMenu:checked ~ #burger > div:nth-child(2) {
    opacity: 0;
}
#sideMenu:checked ~ #burger > div:nth-child(3) {
    transform: translateY(-15px) rotate(-45deg);
}

</style>
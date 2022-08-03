<template>
    <header>
        <router-link :to="{ path: '/' }">
            <h2 class="logo">여행어쩌구</h2>
        </router-link>
        <nav>
            <a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="hamburger fa-solid fa-bars fa-3x dropdown"></i>
            </a>
                <ul class="li_drop dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <router-link :to="{ path: '/Mypage' }">
                        <li class="dropdown-item">마이페이지</li>
                    </router-link>
                    <li class="dropdown-item">내 계정 관리</li>
                    <li class="dropdown-item">DM</li>
                    <router-link :to="{ path: '/Create' }">
                        <li class="dropdown-item">여행 호스팅 하기</li>
                    </router-link>
                    <li class="dropdown-item" v-if="this.$store.state.isLogin" @click="logout">로그아웃</li>
                </ul>
        </nav>
    </header>
</template>

<script>
export default {
    data(){
        return {

        };
    },
    methods: {
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
                })
                }else{
                this.$swal.fire('로그아웃 실패', '', 'error');
                }
            }
        },
        loginCheck(){
            this.isLogin = this.$store.state.isLogin;
        }
    },
    created(){
        this.loginCheck();
    }
}
</script>

<style>

header {
    z-index: 1;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    /* max-width: 100%; */

    height: 100px;
    padding: 1rem;
    color: white;
    font-weight: bold;
    align-items: center;
    background-color: #2d7ac2;
    text-decoration: none;
}
.logo {
    color: white;
}
.hamburger {
    color: white;
    padding: 15px;
    display: flex;
    justify-content: end;
}
li {
    color: white;
    font-size: 1.2rem;
    /* display: inline-block; */
    /* position: relative; */
    cursor: pointer;
    /* z-index: 4; */
    transition: 0.3s;
    min-width: 120px;
}
li:hover {
    background: #285d92 !important;
}
/* .li_drop {
    di
}
.li_drop li {
    transform: translate(0, -108%);
    transition: all 0.5s 0.1s;
    position: relative;
} */
</style>
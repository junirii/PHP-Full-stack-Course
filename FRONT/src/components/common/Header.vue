<template>
    <header>
        <router-link :to="{ path: '/Home' }">
            <h2 class="logo">여행어쩌구</h2>
        </router-link>
        <nav>
            <i class="hamburger fa-solid fa-bars"></i>
            <ul class="li_drop">
                <div>
                    <router-link :to="{ path: '/Mypage' }">
                        <li>마이페이지</li>
                    </router-link>
                    <li>내 계정 관리</li>
                    <li>DM</li>
                    <router-link :to="{ path: '/Create' }">
                        <li>여행 호스팅 하기</li>
                    </router-link>
                    <li >로그아웃</li>
                </div>
            </ul>
        </nav>
    </header>
</template>

<script>
export default {
    methods: {
        async logout(){
        if(this.isLogin === true){
            const res = await this.$post('/user/logout');
            if(res.result === 1){
            this.$store.commit('user', {});
            console.log(this.$store.state.user.iuser);
            this.isLogin = false;
            this.$swal.fire('로그아웃되었습니다.', '', 'success');
            }else{
            this.$swal.fire('로그아웃 실패', '', 'error');
            }
        }
        }
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
    max-width: 20px;
}
li {
    color: white;
    font-size: 1.2rem;
    display: inline-block;
    /* position: relative; */
    cursor: pointer;
    /* z-index: 4; */
    transition: 0.3s;
    min-width: 120px;
}
li:hover {
    background: #285d92 !important;
}
.li_drop li {
    transform: translate(0, -108%);
    transition: all 0.5s 0.1s;
    position: relative;
}
</style>
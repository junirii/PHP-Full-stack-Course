<template>
    <header>
        <div class="header-box">
            <div class="logo-box">
                <router-link :to="{ path: '/' }">
                    <h2 class="logo">여행어쩌구</h2>
                </router-link>
            </div>
            <div class="icons">
                <!-- 임시 -->
                <div class="chat">
                    <button style="margin-top: 100px;" type="button" @click="showDivChat">채팅</button>
                    <div v-if="divChatShow">
                        <div v-for="item in chatRooms" :key="item.itravel">
                            <div style="color: black;" @click="goToChat(item.itravel)">{{ item.title }} : {{ item.lastMsg }}
                            </div>
                        </div>
                        <div class="notifi">
                            <i class="fa-regular fa-bell fa-2x dropdown" @click="selRequest()" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <div>
                                    <li class="dropdown-item">ㅇㅇ</li>
                                    <li class="dropdown-item">Another action</li>
                                    <li class="dropdown-item">Something else here</li>
                                </div>
                            </ul>
                        </div>
                        <div class="notifi">
                            <i class="fa-regular fa-bell fa-2x" style="color: var(--maincolor);"></i>
                        </div>
                        <div class="chat">
                            <router-link :to="{ path: '/chat' }">
                                <i class="fa-regular fa-message fa-2x" style="color: var(--maincolor);"></i>
                            </router-link>
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
                                    <li v-if="this.$store.state.isLogin" @click="goToAllList">전체 리스트</li>
                                    <li v-if="this.$store.state.isLogin" @click="logout">로그아웃</li>
                                    <li v-if="!this.$store.state.isLogin" @click="logout">로그인</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            divChatShow: false,
            chatRooms: []
        };
    },
    methods: {
        goToChat(itravel) {
            this.$store.state.itravel = itravel;
            this.$router.push({ name: 'chat' });
            this.divChatShow = false;
        },
        async showDivChat() {
            this.divChatShow = !this.divChatShow;
            const res = await this.$get(`/chat/selChatRooms`, {});
            this.chatRooms = res.result;
            console.log(this.chatRooms);
        },
        changeFeedIuser() {
        }
    },
    methods: {
        changeFeedIuser() {
            this.$store.state.feedIuser = this.$store.state.user.iuser;
            this.$router.push({ name: 'mypage' });
        },
        async logout() {
            if (this.$store.state.isLogin === true) {
                const res = await this.$post('/user/logout');
                if (res.result === 1) {
                    this.$store.commit('user', {});
                    console.log(this.$store.state.user.iuser);
                    this.$store.state.isLogin = false;
                    this.$swal.fire('로그아웃되었습니다.', '', 'success')
                        .then(async result => {
                            if (result.isConfirmed) {
                                this.$router.push({ name: 'home' });
                            }
                        });
                } else {
                    this.$swal.fire('로그아웃 실패', '', 'error');
                }
            }
        },
        loginCheck() {
            this.isLogin = this.$store.state.isLogin;
        },
        goToAllList() {
            this.$store.state.filter = {
                selectedArea: [],
                f_people: 0,
                f_gender: 0,
                f_age: 0,
                l_price: 10000,
                h_price: 5000000,
                s_date: '1900-01-01',
                e_date: '2032-08-06',
            };
            console.log(this.$store.state.filter);
            this.$router.push({ name: 'list' });
        },
        async selRequest() {

        }
    },
    created() {
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
    width: 90%;
    position: fixed;
    top: 0;
    left: 80px;
    right: 0;

    padding: 1rem;
    color: white;
    font-weight: bold;
    align-items: center;
    background-color: #fff;

    border-bottom: 2px solid var(--mainOrange);
    height: 5rem;
}

.header-box {
    display: flex;
    justify-content: space-between;
}

.logo-box {

    display: flex;
    justify-content: space-between;
}

.logo {
    padding: 12px;
    color: var(--maincolor);
    font-weight: bolder;
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

.chat {
    padding: 6px;
    display: flex;
    cursor: pointer;
    justify-content: center;
    align-items: center;
    position: relative;
    right: 125px;
    bottom: 40px;
}

.burger-wrap {
    cursor: pointer;
    padding: 6px;
}

#menu {
    background: var(--mainOrange);
    width: 15rem;
    height: 100vh;
    position: fixed;
    right: 0;
    transition-timing-function: cubic-bezier(10, 2, 3, 1);
    transform: translateX(50rem);
    top: 0;
    z-index: 0;
    transition: 0.5s;
    padding-top: 100px;
    border-left-color: var(--mainOrange);
}

li {
    color: #fff;
    font-size: 1.2rem;
    cursor: pointer;
    transition: 0.3s;
    min-width: 120px;
    list-style: none;
    padding: 8px;
    text-decoration-line: none;
}

#sideMenu {
    display: none;
}

#sideMenu:checked~#menu {
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

#burger>div {
    height: 3px;
    background-color: var(--maincolor);
    transition: 0.5s;
    z-index: 999;
}

#sideMenu:checked~#burger>div {
    background-color: #fff;
}

#sideMenu:checked~#burger>div:nth-child(1) {
    transform: translateY(15px) rotate(45deg);
}

#sideMenu:checked~#burger>div:nth-child(2) {
    opacity: 0;
}

#sideMenu:checked~#burger>div:nth-child(3) {
    transform: translateY(-15px) rotate(-45deg);
}
</style>
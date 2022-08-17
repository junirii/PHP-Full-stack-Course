<template>
    <header>
        <!-- 메인페이지용 헤더 -->
        <div class="header1" v-if="$route.name == 'home'">
            <div class="header-box">
                <div class="logo-box">
                    <router-link :to="{ name: 'home' }">
                        <!-- <h2 class="logo1">모임모임 moimmoim</h2> -->
                        <!-- <img class="logo2" src="../../../static/img_used/logo.png" alt=""> -->
                        <img class="logo1" src="../../../static/img_used/homelogo.png" alt="">
                    </router-link>
                </div>

                <div class="icons1">
                    <img class="profile-img" v-if="this.$store.state.user.social_type == 1" :src="`${this.$store.state.user.profile_img}`" style="width:40px">
                    <img class="profile-img" v-if="this.$store.state.user.social_type == 0" :src="`/static/img/profile/${this.$store.state.user.iuser}/${this.$store.state.user.profile_img}`"
                     style="width:40px">
                    <div class="user-name1" v-if="this.$store.state.isLogin">
                        <!-- <img class="header-profile-img"
                            :src="`/static/img/profile/${item.iuser}/${item.profile_img}`"
                            onerror="this.onerror=null; this.src='/static/img/profile/common/defaultImg.webp';"
                            alt="프로필사진" id="profile-img"> -->
                        {{ this.$store.state.user.nick }}님, 환영합니다!
                    </div>
                    <div class="chat" v-if="this.$store.state.isLogin">
                        <i class="fa-regular fa-message fa-2x dropdown" style="color: #fff;" @click="showDivChat();"
                            type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false"></i>
                        <span id="unreadCntAll" style="" class="position-absolute translate-middle badge rounded-pill bg-danger d-none">{{unreadCntAll}}</span>
                        <!-- <div style="background-color: #fff;"> -->
                        <ul class="dropdown-menu">
                            <!-- <ul v-if="divChatShow" style="margin-top: 100px;">  -->
                            <div v-for="item in chatRooms" :key="item.itravel">
                                <li class="dropdown-item">
                                    <div style="color: var(--mainOrange);" @click="goToChat(item.itravel)">
                                        <div style="font-size: 18px; font-weight: bolder;">{{ item.title }}</div>
                                        {{ item.lastMsg }}
                                        <span v-if="this.$store.state.unreadCnt[item.itravel]"
                                            style="background-color: var(--mainOrange); color:#fff; font-weight: bolder;">
                                            {{ this.$store.state.unreadCnt[item.itravel] }}
                                        </span>
                                    </div>
                                </li>
                                <hr>
                            </div>
                        </ul>
                        <!-- </div> -->
                    </div>

                    <div class="notifi" v-if="this.$store.state.isLogin">
                        <i class="fa-regular fa-bell fa-2x dropdown" style="color: #fff;" @click="selRequest();"
                            type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false"></i>
                        <span id="unreadAlarm" style="color: red; font-weight: bold;">{{ unreadAlarm }}</span>
                        <ul class="dropdown-menu">
                            <div :key="item.iuser" v-for="item in selStateList">
                                <li v-if="item.isconfirm == 0" class="dropdown-item" style="cursor: default;">
                                    <div>신청이 왔습니다.</div> {{ item.profile_img }} {{ item.nick }} 님께서 {{ item.title }}
                                    <button @click="request(item.itravel, item.iuser)">수락</button>
                                    <button @click="requestDel(item.itravel, item.iuser)">거절</button>
                                </li>
                                <hr>
                                <li v-if="item.isconfirm == 3" class="dropdown-item" style="cursor: default;">
                                    <div> {{ item.nick }}님 신청이 거절되었습니다.</div> {{ item.title }}
                                    <button @click="requestNo(item.itravel, item.iuser)">확인</button>
                                </li>
                                <hr>
                                <li v-if="item.isconfirm == 1" class="dropdown-item" style="cursor: default;">
                                    <div> {{ item.nick }}님 신청이 수락되었습니다.</div> {{ item.title }}
                                    <button @click="requestYes(item.itravel, item.iuser, $event)">확인</button>
                                </li>
                            </div>
                        </ul>
                    </div>
            
                    <div class="burger-wrapper" v-if="this.$store.state.isLogin">
                        <input class="sidebar" type="checkbox" id="sideMenu">
                        <label id="burger1" for="sideMenu">
                            <div></div>
                            <div></div>
                            <div></div>
                        </label>
                        <nav id="menu">
                            <ul>
                                <li v-if="this.$store.state.isLogin" @click="goToMyPage(); sidebarNone()">마이페이지</li>
                                <router-link :to="{ path: '/MyAccount' }" @click="sidebarNone">
                                    <li v-if="this.$store.state.isLogin">회원정보 수정</li>
                                </router-link>
                                <router-link :to="{ path: '/Create' }" @click="sidebarNone">
                                    <li v-if="this.$store.state.isLogin">여행 호스팅 하기</li>
                                </router-link>
                                <li v-if="this.$store.state.isLogin" @click="goToAllList(); sidebarNone();">전체 리스트</li>
                                <li v-if="this.$store.state.isLogin" @click="logout">로그아웃</li>
                                <li v-if="!this.$store.state.isLogin" @click="logout">로그인</li>
                            </ul>
                            <div class="overlay"></div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- 메인페이지 아니면 -->
        <div class="header2" v-if="$route.name !== 'home'">
            <div class="header-box">
                <div class="logo-box">
                    <router-link :to="{ name: 'home' }">
                        <!-- <h2 class="logo2">모임모임 moimmoim</h2> -->
                        <img class="logo2" src="../../../static/img_used/moim4.png" alt="">
                    </router-link>
                </div>
                <div class="icons2">
                    <img class="profile-img" v-if="this.$store.state.isLogin" :src="`/static/img/profile/${this.$store.state.user.iuser}/${this.$store.state.user.profile_img}`"
                     style="width:40px">
                    <div class="user-name2">{{ this.$store.state.user.nick }}님, 환영합니다!</div>
                
                    <div class="chat">
                        <i class="fa-regular fa-message fa-2x dropdown" style="color: var(--maincolor);" @click="showDivChat();"
                            type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false"></i>
                        <span id="unreadCntAll" style="" class="position-absolute translate-middle badge rounded-pill bg-danger d-none">{{unreadCntAll}}</span>
                        <span id="unreadCntAll" style="color: red; font-weight: bolder;" class="d-none">{{ unreadCntAll
                            }}</span>
                        <ul class="dropdown-menu">
                            <div v-for="item in chatRooms" :key="item.itravel">
                                <li class="dropdown-item">
                                    <div style="color: var(--mainOrange);" @click="goToChat(item.itravel)">
                                        <div style="font-size: 18px; font-weight: bolder;">{{ item.title }}</div>
                                        {{ item.lastMsg }}
                                        <span v-if="this.$store.state.unreadCnt[item.itravel]"
                                            class="position-absolute translate-middle badge rounded-pill bg-danger end-0 bottom-10">
                                            {{ this.$store.state.unreadCnt[item.itravel] }}
                                        </span>
                                    </div>
                                </li>
                                <hr>
                            </div>
                        </ul>
                    </div>

                    <div class="notifi">
                        <i class="fa-regular fa-bell fa-2x dropdown" style="color: var(--maincolor);"
                            @click="selRequest();" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false"></i>
                        <span id="unreadAlarm" style="color: red; font-weight: bold;">{{unreadAlarm}}</span>
                        <ul class="dropdown-menu">
                            <div :key="item.iuser" v-for="item in selStateList">
                                <li v-if="item.isconfirm == 0" class="dropdown-item" style="cursor: default;">
                                    <div class="new-request">신청이 왔습니다.</div> {{ item.profile_img }} {{ item.nick }} 님께서 {{ item.title }}
                                    <button @click="request(item.itravel, item.iuser)">수락</button>
                                    <button @click="requestDel(item.itravel, item.iuser)">거절</button>
                                </li>
                                <hr>
                                <li v-if="item.isconfirm == 3" class="dropdown-item" style="cursor: default;">
                                    <div> {{ item.nick }}님 신청이 거절되었습니다.</div> {{ item.title }}
                                    <button @click="requestNo(item.itravel, item.iuser)">확인</button>
                                </li>
                                <hr>
                                <li v-if="item.isconfirm == 1" class="dropdown-item" style="cursor: default;">
                                    <div> {{ item.nick }}님 신청이 수락되었습니다.</div> {{ item.title }}
                                    <button @click="requestYes(item.itravel, item.iuser, $event)">확인</button>
                                </li>
                            </div>
                        </ul>
                    </div>

                    <div class="burger-wrapper">
                        <input class="sidebar" type="checkbox" id="sideMenu">
                        <label id="burger2" for="sideMenu">
                            <div></div>
                            <div></div>
                            <div></div>
                        </label>
                        <nav id="menu">
                            <ul>
                                <li v-if="this.$store.state.isLogin" @click="goToMyPage(); sidebarNone()">마이페이지</li>
                                <router-link :to="{ path: '/MyAccount' }" @click="sidebarNone">
                                    <li v-if="this.$store.state.isLogin">회원정보 수정</li>
                                </router-link>
                                <router-link :to="{ path: '/Create' }" @click="sidebarNone">
                                    <li v-if="this.$store.state.isLogin">여행 호스팅 하기</li>
                                </router-link>
                                <li v-if="this.$store.state.isLogin" @click="goToAllList(); sidebarNone()">전체 리스트</li>
                                <li v-if="this.$store.state.isLogin" @click="logout">로그아웃</li>
                                <li v-if="!this.$store.state.isLogin" @click="logout">로그인</li>
                            </ul>
                            <div class="overlay"></div>
                        </nav>
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
            // divChatShow: false,
            chatRooms: [],
            selStateList: [],
            refusalMsg: [],
            agreeMag: [],
            unreadCntAll: this.$store.state.unreadCntAll
        };
    },
    methods: {
        setDefaultImg() {
            document.querySelector('#profile-img').src = '/static/img/profile/common/defaultImg.webp';
        },
        sidebarNone() {
            console.log('test!!');
            const sidebar = document.querySelector('.sidebar');
            sidebar.checked = false;
        },
        goToChat(itravel) {
            // this.$store.state.itravel = itravel;
            this.$router.push({ name: 'chat', query: { itravel: itravel } });
            // this.divChatShow = false;
        },
        async showDivChat() {
            // this.divChatShow = !this.divChatShow;
            const res = await this.$get(`/chat/selChatRooms`, {});
            this.chatRooms = res.result;
            console.log(this.chatRooms);
        },
        goToMyPage() {
            const feedIuser = this.$store.state.user.iuser;
            this.$store.state.feedIuser = feedIuser;
            this.$router.push({ name: 'mypage', query: { feedIuser: feedIuser } });
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
                selectedLocation: null,
                f_people: 0,
                f_gender: 0,
                f_age: 0,
                l_price: 10000,
                h_price: 5000000,
                s_date: '1900-01-01',
                e_date: '2032-08-06',
            };
            console.log(this.$store.state.filter);
            this.$router.push({ name: 'list', query: { filter: 0 } });
        },
        async selRequest() {
            const res2 = await this.$get(`/travel/selRequest/${this.iuser}`, {});
            this.selStateList = res2.result;
            console.log(res2);
        },
        async request(itravel, iuser) {
            if (confirm("수락 하시겠습니까?") == true) {
                const res = await this.$put(`/travel/selRequest`, {
                    itravel: itravel,
                    iuser: iuser,
                    isyes: 1
                });
                console.log(res);
            }
        },
        async requestDel(itravel, iuser) {
            if (confirm("거절하시겠습니까?") == true) {
                const res = await this.$put(`/travel/selRequest`, {
                    itravel: itravel,
                    iuser: iuser,
                    isyes: 0
                });
                console.log(res.result);
                console.log('거절됨');
            }
        },
        async requestYes(itravel, iuser, e) {
            console.log(itravel);
            console.log(iuser);
            const res = await this.$put(`/travel/selRequest`, {
                itravel: itravel,
                iuser: iuser,
            });
            if (res.result == 1) {
                e.target.parentNode.remove();
                const resChatRoom = await this.$post(`/chat/insChatRoom`, {
                    itravel: itravel,
                    iuser: iuser
                });

                if (resChatRoom.result == 1) {
                    this.$router.push({
                        name: 'chat', query: {
                            itravel: itravel,
                            isnew: 1
                        }
                    });
                }
            }
        },
        async requestNo(itravel, iuser) {
            const res = await this.$delete(`/travel/selYesNo/${itravel}/${iuser}`);
            console.log(res);
        }
    },
    created() {
        this.loginCheck();
    }
}
</script>

<style scoped>
* {
    margin: 0;
}
html {
    font-size: 16px;
    font-family: 'LeferiPoint-WhiteA';
}
.header1 { 
    z-index: 1;
    width: 90%;
    position: fixed;
    top: 0;
    left: 80px;
    right: 0;

    padding: 1rem;
    font-weight: bold;
    align-items: center;

    border-bottom: 2px solid var(--mainOrange);
    height: 5rem;
}
.header2 {
    z-index: 2;
    width: 90%;
    position: fixed;
    top: 0;
    left: 80px;
    right: 0;

    padding: 1rem;
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
    width: 40%;
    display: flex;
    justify-content: space-between;
}
.logo1 {
    padding: 11px;
    /* color: #fff;
    font-weight: bolder; */
    width: 284px;
}
.logo2 {
    padding: 11px;
    /* color: var(--maincolor);
    font-weight: bolder; */
    width: 284px;
}
.user-name1 { 
    font-size: 1.5rem;
    color: #fff;
}
.user-name2 { 
    font-size: 1.5rem;
    color: var(--maincolor);
}
/* .header-profile-img {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 50%;
} */
.icons1 {
    display: flex;
    justify-content: space-between;
    color: #fff;
    width: 405px;
    padding-top: 10px;
}
.icons1 .profile-img {
	border-radius : 50%;
}
.icons2 {
    display: flex;
    justify-content: space-between;
    color: var(--maincolor);
    width: 405px;
    padding-top: 10px;
}
.icons2 .profile-img {
	border-radius : 50%;
}
.dropdown-item {
    color: var(--mainOrange);
    font-size: 15px;
    font-weight: bold;
}
hr {
    color: var(--mainOrange);
}
button {
    border: 2px solid var(--mainOrange);
    border-radius: 13px;
    padding: 2px;
    background: #fff;
    font-weight: bold;
    color: var(--mainOrange);
    margin-left: 5px;
}
.new-request { 
    text-decoration: underline;
    text-underline-position: under;
}

/*사이드 바*/
.burger-wrapper {
    cursor: pointer;
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
    z-index: 10;
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
#burger1, #burger2 {
    /* position: absolute; */
    cursor: pointer;
    width: 2rem;
    height: 2rem;
    right: 1rem;
    top: 1.5rem;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
}
#burger1>div {
    height: 3px;
    background-color: #fff;
    transition: 0.5s;
    z-index: 999;
}
#burger2>div {
    height: 3px;
    background-color: var(--maincolor);
    transition: 0.5s;
    z-index: 999;
}
#sideMenu:checked~#burger1>div {
    background-color: #fff;
}
#sideMenu:checked~#burger1>div:nth-child(1) {
    transform: translateY(15px) rotate(45deg);
}
#sideMenu:checked~#burger1>div:nth-child(2) {
    opacity: 0;
}
#sideMenu:checked~#burger1>div:nth-child(3) {
    transform: translateY(-15px) rotate(-45deg);
}

#sideMenu:checked~#burger2>div {
    background-color: #fff;
}
#sideMenu:checked~#burger2>div:nth-child(1) {
    transform: translateY(15px) rotate(45deg);
}
#sideMenu:checked~#burger2>div:nth-child(2) {
    opacity: 0;
}
#sideMenu:checked~#burger2>div:nth-child(3) {
    transform: translateY(-15px) rotate(-45deg);
}
#unreadCntAll{
    /* display: block;
    width: 20px;
    height: 20px;
    background-color: red;
    color: white;
    font-weight: bolder;
    border-radius: 50%;
    font-size: small;
    text-align: center;
    z-index: 10px; */
}
</style>
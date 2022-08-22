<template>
  <div id="wrap">
    <Header></Header>
    <div class="main"><router-view :key="$route.fullPath" /></div>
    <Footer v-if="$route.name !== 'home'"></Footer>
  </div>
</template>

<script>
import Header from '/src/components/common/Header';
import Footer from '/src/components/common/Footer';

export default {
  name: 'App',
  components: {
    Header,
    Footer
  },
  created() {
    //채팅 알림
    this.$socket.on('update', data => {
      const inputChat = document.querySelector('#inputChat');
      if((inputChat && data.room !== this.$store.state.itravel) || !inputChat){
        this.$store.state.unreadCntAll++;
        const spanUnreadCntAll = document.querySelector('#unreadCntAll');
        spanUnreadCntAll.classList.remove('d-none');
        spanUnreadCntAll.innerText = this.$store.state.unreadCntAll;

        if(this.$store.state.unreadCnt[data.room]){
          this.$store.state.unreadCnt[data.room]++;
        }else{
          this.$store.state.unreadCnt[data.room] = 1;
        }
      }
    });
    this.$socket.on('enterRoom', data => {
      const spanUnreadCntAll = document.querySelector('#unreadCntAll');
      if(data.unreadCntAll > 0){
        spanUnreadCntAll.innerText = data.unreadCntAll;
        spanUnreadCntAll.classList.remove('d-none');
      }else{
        spanUnreadCntAll.classList.add('d-none');
      }
    });

    //isconfirm 변경
    this.changeIsConfirm();
  },
  methods: {
    async changeIsConfirm(){
      globalThis.this = this;
      const today = new Date();
      const year = today.getFullYear();
      const month =  ("0" + (today.getMonth() + 1)).slice(-2);
      const day = ("0" + today.getDate()).slice(-2);
      const todayDate = `${year}-${month}-${day}`;
      if(this.$store.state.isLogin){
        const loginIuser = this.$store.state.user.iuser;
        const res = await this.$get(`/travel/joiningTravel/${loginIuser}`, {});
        const joiningTravelList = res.result;
        joiningTravelList.forEach(async function(item){
          if(item.e_date < todayDate){
            const res = await globalThis.this.$put(`/travel/updIsConfirm`, {
              itravel: item.itravel,
              loginIuser: loginIuser
            });
          }
        });
      }
    }
  }
}
</script>


<style>
* { margin: 0; box-sizing: border-box; }
html, body { height: 100%; margin: 0; padding: 0;  }
#app {
  font-family: 'LeferiPoint-WhiteA';
  font-weight: bolder;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  height: 100%;
}
#wrap {
  min-height: 100%;
  position: relative;
}
</style>

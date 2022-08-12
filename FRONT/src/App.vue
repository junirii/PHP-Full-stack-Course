<template>
  <div id="wrap">
    <Header v-if="$route.name !== 'home'"></Header>
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
    console.log('success');
    console.log(this.$store.state.unreadCntAll);
    this.$socket.on('update', data => {
      const inputChat = document.querySelector('#inputChat');
      if((inputChat && data.room !== this.$store.state.itravel) || !inputChat){
        console.log(this.$store.state.unreadCntAll);
        this.$store.state.unreadCntAll++;
        console.log(this.$store.state.unreadCntAll);
        console.log('all: ' + this.$store.state.unreadCntAll);
        const spanUnreadCntAll = document.querySelector('#unreadCntAll');
        spanUnreadCntAll.classList.remove('d-none');
        spanUnreadCntAll.innerText = this.$store.state.unreadCntAll;

        if(this.$store.state.unreadCnt[data.room]){
          this.$store.state.unreadCnt[data.room]++;
        }else{
          this.$store.state.unreadCnt[data.room] = 1;
        }
        console.log(`${data.room} : ${this.$store.state.unreadCnt[data.room]}`);
      }
    });
    this.$socket.on('enterRoom', data => {
      const spanUnreadCntAll = document.querySelector('#unreadCntAll');
      if(data.unreadCntAll > 0){
        spanUnreadCntAll.innerText = data.unreadCntAll;
      }else{
        spanUnreadCntAll.classList.add('d-none');
      }
      console.log(data.unreadCntAll);
    });
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
  /* padding-bottom: 100px; */
}
/* footer {
  position: absolute;
  bottom: 0;
  left: 80px;
  right: 0;
} */
/* .main {
  overflow: hidden;
} */
</style>

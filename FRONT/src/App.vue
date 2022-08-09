<template>
  <div id="wrap">
    <Header v-if="$route.name !== 'home'"></Header>
    <div class="main"><router-view/></div>
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
  }
}
</script>


<style>
* { margin: 0; box-sizing: border-box; }
html, body { height: 100%; margin: 0; padding: 0;  }
#app {
  /* font-family: Avenir, Helvetica, Arial, sans-serif; */
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
footer {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
}
/* .main {
  overflow: hidden;
} */
</style>

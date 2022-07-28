<template>
<div class="location">
  <div>
    <h3>여행지 선택</h3>
  </div>
  <div>
    시/도
    <select>
      <option value=""></option>
    </select><br>
    군/구
    <select>
      <option value=""></option>
    </select>
  </div>
    <router-link :to="{ path: '/Option' }">
      <button type="button">↓</button>
    </router-link>
  <div class="box d-flex">
    <div class="map"><img id="map" src="../../mapImg/map_1.png" alt="map"></div>
    <div class="container-map">
    <router-link :to="{ path: '/Option' }">
      <div class="Center"><img src="../../mapImg/i.png" alt="수도권"></div>
      <div class="Gang"><img src="../../mapImg/Gang.png" alt="강원도"></div>
      <div class="K1"><img src="../../mapImg/k.png" alt="경상북도"></div>
      <div class="K2"><img src="../../mapImg/k2.png" alt="경상남도"></div>
      <div class="C1"><img src="../../mapImg/chung1.png" alt="충청북도"></div>
      <div class="C2"><img src="../../mapImg/chung2.png" alt="충청남도"></div>
      <div class="J1"><img src="../../mapImg/j1.png" alt="전라북도"></div>
      <div class="J2"><img src="../../mapImg/j2.png" alt="전라남도"></div>
      <div class="JJ"><img src="../../mapImg/jj.png" alt="제주도"></div>
      <div class="I"><img src="../../mapImg/island.png" alt="울릉/독도"></div>
    </router-link>
    </div>
  </div>
</div>

</template>

<script>
export default {

}
</script>

<style scoped>

.location { 
  z-index: auto;
  margin: 0 auto;
  padding: 150px;
}
.box {
  margin-top: 100px;
  /* float: left; */
  /* position: relative; */
  /* display: flex; */
  justify-content: center;
  /* align-items: center; */
}
.map {
  position: relative;
  top: 0;
  left: 0;
}
.container-map {
  position: absolute;
}
.Center {
  /* position: relative; */
  
}
.Gang {
  /* position: relative; */
  
}
.K1 {
  /* position: relative; */
  
}
.K2 {
  position: relative;
  
}
.C1 {
  position: relative;
 
}
.C2 {
  position: relative;

}
.J1 {
  position: relative;

}
.J2 {
  position: relative;
 
}
.JJ {
  position: relative;
  
}
.I {
  position: relative;
  
}
img { cursor: pointer; }
.Center:hover, .C1:hover, .C2:hover, .J1:hover, .J2:hover, .JJ:hover {
  transform: translateX(-10px);
  transition: 0.3s;
}
.Gang:hover, .K1:hover, .K2:hover, .I:hover {
  transform: translateX(10px);
  transition: 0.3s;
}
  
</style>

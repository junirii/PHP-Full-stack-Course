<template>
<div>
  <div>
    <h3>여행지 설정</h3>
  </div>
  <div>
    (지도 예정)<br>
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
  <div class="container">
    <div class="box">
      <!-- 파일경로: ../../mapImg/파일이름
           세 번째줄 파일이름 gang -> Gang으로 바꾸기 -->
      <div class="map"><img id="map" src="../../mapImg/map_1.png" alt="map"></div>
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
    </div>
  </div>
  <div>
  </div>
</div>

</template>

<script>
export default {

}
</script>

<style>
  /* @import "../static/css/map.css"; */

  * { margin: 0; padding: 0; }

  .container {
    width: 600px;
    margin: 100px auto 0;
  }

  .box {
    float: left;
    width: 255px;
    height: 515px;
    margin: 0 30px;
    position: relative;
    max-width: 700px;
  }
  .map {
    position: absolute;
    top: 0;
    left: 0;
  }
  /* #map {
    max-width: 700px;
  } */
  .Center {
    position: relative;
    top: 55px;
    left: 33px;
  }
  .Gang {
    position: relative;
    bottom: 344px;
    left: 231px;
  }
  .K1 {
    position: relative;
    bottom: 365px;
    left: 377px;
  }
  .K2 {
    position: relative;
    bottom: 446px;
    left: 324px;
  }
  .C1 {
    position: relative;
    bottom: 1112px;
    left: 258px;
  }
  .C2 {
    position: relative;
    bottom: 1377px;
    left: 21px;
  }
  .J1 {
    position: relative;
    bottom: 1418px;
    left: 74px;
  }
  .J2 {
    position: relative;
    bottom: 1459px;
    left: 2px;
  }
  .JJ {
    position: relative;
    bottom: 1372px;
    right: 36px;
  }
  .I {
    position: relative;
    bottom: 2241px;
    left: 818px;
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

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
    <div class="container-map">
      <router-link :to="{ path: '/Option' }">
        <div class="sec1">
          <img class="center" src="../../mapImg/i.png" alt="수도권">
          <img class="gang" src="../../mapImg/Gang.png" alt="강원도">
        </div>
        <div class="sec2">
          <img class="K1" src="../../mapImg/k.png" alt="경상북도">
          <img class="I" src="../../mapImg/island.png" alt="울릉/독도">
          <img class="C1" src="../../mapImg/chung1.png" alt="충청북도"><img class="C2" src="../../mapImg/chung2.png" alt="충청남도">
        </div>
        <div class="sec3">
          <img class="K2" src="../../mapImg/k2.png" alt="경상남도">
          <img class="J1" src="../../mapImg/j1.png" alt="전라북도">
          <img class="J2" src="../../mapImg/j2.png" alt="전라남도">
          <img class="JJ" src="../../mapImg/jj.png" alt="제주도">
        </div>
    <img class="map" src="../../mapImg/map_1.png" alt="map">
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
img {
  vertical-align: middle;
  cursor: pointer;
}
.map {
  max-width: 500px;
  /* position: relative;
  top: 0;
  left: 0; */
}
.sec1, .sec2, .sec3 {
  position: absolute;
}
.center {
  max-width: 170px;
  position: absolute;
  top: 24px;
  left: 13px;
} 
.gang {
  max-width: 225px;
  position: absolute;
  left: 114px;
  top: 1px;
}
.K1 {
  position: absolute;
  top: 172px;
  max-width: 178px;
  left: 188px;
}
.K2 {
  position: absolute;
  max-width: 190px;
  top: 333px;
  left: 162px;
}
.C1 {
  position: absolute;
  max-width: 135px;
  top: 156px;
  left: 126px;
}
.C2 {
  position: absolute;
  max-width: 156px;
  top: 182px;
  left: 5px;
}
.J1 {
  position: absolute;
  max-width: 150px;
  top: 300px;
  left: 36px;
}
.J2 {
  position: absolute;
  max-width: 176px;
  top: 388px;
  left: -2px;
}
.JJ {
  position: absolute;
  max-width: 81px;
  top: 575px;
  left: 2px;
}
.I {
  position: absolute;
  max-width: 59px;
  top: 189px;
  left: 439px;
}
.center:hover, .C1:hover, .C2:hover, .J1:hover, .J2:hover, .JJ:hover {
  transform: translateX(-5px);
  transition: 0.3s;
}
.gang:hover, .K1:hover, .K2:hover, .I:hover {
  transform: translateX(5px);
  transition: 0.3s;
}
  
</style>


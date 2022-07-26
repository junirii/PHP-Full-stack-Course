<template>
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
  <div>
    <router-link :to="{ path: '/Option' }">
      <button type="button">↓</button>
    </router-link>
  </div>
</template>

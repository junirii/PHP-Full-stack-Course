<template>
  <h3>옵션 선택</h3>
  <div>
    <div>
      <form>
        <span>인원</span>
        <input type="number">
        <br>
        
        <span>성별</span>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">남성</label>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">여성</label>
        <input type="radio" id="nolimit_gender" name="gender" value="other">
        <label for="nolimit_gender">혼성</label>
        <br>

        <span>연령대</span>
        <input type="radio" id="20s" name="age" value="male">
        <label for="male">20대</label>
        <input type="radio" id="30s" name="age" value="female">
        <label for="female">30대</label>
        <input type="radio" id="40s" name="age" value="other">
        <label for="other">40대</label>
        <input type="radio" id="nolimit_age" name="age" value="other">
        <label for="nolimit_age">제한없음</label>
        <br>

        <span>비용</span>
        <input type="range" name="points" min="0" max="1000000">
      </form>
    </div>
  </div>
  <div>
    <router-link :to="{ path: '/Calender' }">
      <button type="button">↓</button>
    </router-link>
  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>
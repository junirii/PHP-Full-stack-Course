<template>
  <div>message</div>
  <div>
    <router-link :to="{ path: '/Map' }">
      <button type="button">시작하기</button>
    </router-link>
    <router-link :to="{ path: '/Create' }">
      <button type="button">글쓰기</button>
    </router-link>
    <button type="button" @click="modalShow=true">로그인</button>
  </div>
  <LoginModal :show="modalShow" @close="hiddenModal" />
</template>

<script>
import LoginModal from '/src/components/common/LoginModal.vue';

export default {
  name: 'Home',
  data(){
    return {
      modalShow: false,
    };
  },
  components: {
    LoginModal
  },
  methods: {
    showModal(){
      this.modalShow = true;
    },
    hiddenModal(){
      this.modalShow = false;
    },
  }
}
</script>
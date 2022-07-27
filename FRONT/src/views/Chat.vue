<template>
  
</template>

<script>
export default {
  methods: {
    getIboard(){
      const iboard = this.$route.params.iboard; // iboard 가져옴
    }
  },
  created() {
    this.getIboard();
  },
}
</script>

<style>

</style>
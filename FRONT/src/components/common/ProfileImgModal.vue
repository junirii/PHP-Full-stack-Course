<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask modal-lg">
      <div class="modal-wrapper" style="z-index: 10;" @click="$emit('close')">
        <div class="modal-container" @click.stop="">
          <div class="modal-body">
            <div class="modal-header justify-content-center p-4">
              <h5 class="modal-title fw-bold">프로필 사진 바꾸기</h5>
            </div>
            <div class="modal-body p-0 pt-3 pb-3" id="id-modal-body">
              <div id="uploadImg" class="text-center" @click="clickForm">
                <span id="btnInsProfilePic" class="text-primary fw-bold pointer">사진 업로드</span>
                <input class="d-none" type="file" accept="image/*" name="imgs" id="inputImg" @change="uploadImg($event.target.files)">
              </div><hr>
              <div class="text-center text-danger fw-bold pointer" @click="delProfileImg">
                <span id="btnDelCurrentProfilePic">현재 사진 삭제</span>
              </div><hr>
              <div class="text-center pointer" id="btnProfileImgModalClose" @click="$emit('close');">취소</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script>
export default {
  name: "ProfileImgModal",
  props: {
    show: Boolean,
  },
  data(){
    return {
      iuser: this.$store.state.user.iuser
    }
  },
  methods: {
    async delProfileImg(){
      const res = await this.$delete(`/user/profileImg`, {});
      if(res.result === 1){
        this.$emit('close');
        this.$emit('defaultImg');
      }
    },
    clickForm(){
      const inputImg = document.querySelector('#inputImg');
      inputImg.click();
    },
    async uploadImg(files){
      const profileImg = await this.$base64(files[0]);
      const fData = {
        profileImg: profileImg,
        iuser: this.iuser
      };
      const res = await this.$put(`/user/profileImg`, fData);
      if(res.result){
        this.$store.state.user.profile_img = res.result;
        this.$emit('close');
        this.$emit('update');
      }
    }
  }
}
</script>
<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask modal-md">
      <div class="modal-wrapper" style="z-index: 10;" @click="$emit('close')">
        <div class="modal-container" style="width: 350px; border-radius: 15px;" @click.stop="">
          <div class="modal-body">
            <div class="modal-header justify-content-center p-4">
              <h5 class="modal-title fw-bold">프로필 사진 바꾸기</h5>
            </div>
            <div class="modal-body p-0 pt-3 pb-3" id="id-modal-body">
              <div id="uploadImg" class="text-center" @click="clickForm">
                <span id="btnInsProfilePic" class="text-primary fw-bold pointer">사진 업로드</span>
                <input class="d-none" type="file" accept="image/*" name="imgs" id="inputImg" @change="uploadImg($event.target.files)">
              </div><hr>
              <div class="text-center text-danger fw-bold pointer" @click="delProfileImg()">
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
      const res = await this.$delete(`/user/profileImg`, {}); // 컨트롤러 이름 / 함수
      if(res.result === 1){
        this.$emit('close');
        this.$emit('defaultImg');
        this.$store.state.user.profile_img = null;
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

<style scoped>
.loginButton {
  width: 220px;
}
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-footer {
  text-align: center;
}

.modal-login-button {
  display: inline-block;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.swal2-container {
  z-index: 20000 !important;
}


.test {
  display: flex;
  justify-content: center;
  align-items: center;
}

.google-div img {
  width: 220px;
  cursor: pointer;
}

#btnInsProfilePic, #btnDelCurrentProfilePic, #btnProfileImgModalClose {
  cursor: pointer;
}
</style>
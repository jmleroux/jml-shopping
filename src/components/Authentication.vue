<template>
  <button
    type="button"
    class="btn btn-outline-primary btn-sm"
    @click="logout"
    v-if="isAuthenticated"
  >
    Logout
  </button>
  <div v-else>
    <button
      type="button"
      class="btn btn-outline-primary btn-sm"
      @click="googleSignIn"
    >
      <img
        class="button-logo"
        :src="require('../assets/google_logo.svg')"
        alt="Google logo"
      />
      Sign In with Google
    </button>
  </div>
</template>

<script setup>
import { signInWithPopup, GoogleAuthProvider, signOut } from "firebase/auth";

import useAuthentication from "../useAuthentication";
import { auth } from "../db";
import toast from '../useToast.js'

const provider = new GoogleAuthProvider();
const { isAuthenticated } = useAuthentication();

const googleSignIn = () => {
  signInWithPopup(auth, provider).then(() => {
      toast("You are now connected")
  });
};

const logout = () => {
  signOut(auth, provider).then(() => {
      toast("You have been disconnected")
  });
};
</script>

<style lang="scss" scoped>
.button-logo {
  width: 25px;
}
</style>

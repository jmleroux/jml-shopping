<template>
  <div class="home">
    <h1>Home</h1>
    <button
      type="button"
      class="btn btn-outline-primary btn-lg"
      @click="googleSignIn"
    >
      <img
        class="button-logo"
        :src="require('../assets/google_logo.svg')"
        alt="Google logo"
      />
      Sign In with Google
    </button>
    <button
      type="button"
      class="btn btn-outline-primary btn-lg"
      @click="logout"
    >
      Logout
    </button>
  </div>
</template>

<script setup>
import {
  getAuth,
  signInWithPopup,
  GoogleAuthProvider,
  signOut,
} from "firebase/auth";

import { userExists } from "../db";

const provider = new GoogleAuthProvider();
const auth = getAuth();

const googleSignIn = () => {
  signInWithPopup(auth, provider)
    .then((result) => {
      const user = result.user;
      return userExists(user.email);
    })
    .then((result) => {
      if (result.size == 0) {
        this.logout();
      }
    });
};
const logout = () => {
  signOut(auth, provider).then(() => {
    alert("Successfully signed out.");
  });
};
</script>

<style lang="scss" scoped>
.button-logo {
  width: 25px;
}
</style>

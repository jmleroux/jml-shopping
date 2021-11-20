<template>
  <div class="home">
    <h1>Home</h1>
    <b-button variant="outline-primary" @click="googleSignIn">
      <b-img class="button-logo" :src="require('../assets/google_logo.svg')" fluid alt="Google logo"></b-img>
      Sign In with Google
      </b-button>
    <button @click="logout">Logout</button>
  </div>
</template>

<script>
import {
  getAuth,
  signInWithPopup,
  GoogleAuthProvider,
  signOut,
} from "firebase/auth";

import { userExists } from "../db";

const provider = new GoogleAuthProvider();
const auth = getAuth();

export default {
  name: "Home",
  methods: {
    googleSignIn() {
      signInWithPopup(auth, provider)
        .then((result) => {
          const user = result.user;
          return userExists(user.email);
        }).then(result => {
          if (result.size == 0) {
            this.logout()
          }
        })
    },
    logout() {
      signOut(auth, provider).then(() => {
        alert("Successfully signed out.");
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.button-logo {
  width: 30px;;
}
</style>

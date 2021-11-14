<template>
  <v-app>
    <Navbar />

    <v-main>
      <v-slide-y-transition mode="out-in">
        <router-view />
      </v-slide-y-transition>
    </v-main>
    <Footer />
  </v-app>
</template>

<script>
  import Navbar from "@/components/Navbar"
  import Footer from "@/components/Footer"

  export default {
    name: "app",
    components: { Navbar, Footer },
  };
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>

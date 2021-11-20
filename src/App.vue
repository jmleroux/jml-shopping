<template>
  <section id="app">
    <Navbar />
    <section id="main">
      <div class="container">
          <router-view />
      </div>
    </section>
    <Footer />
  </section>
</template>

<script>
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

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

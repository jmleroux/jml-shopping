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

<script setup>
import Navbar from "@/components/NavbarComponent.vue";
import Footer from "@/components/FooterComponent.vue";
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>

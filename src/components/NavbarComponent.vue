<template>
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h1 class="navbar-brand">JML Shopping</h1>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent" ref="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <router-link
            v-for="item in filteredLinks"
            :key="item.label"
            :to="item.route"
            class="nav-item nav-link"
            @click="hideNavbarmenu"
            >{{ item.label }}</router-link
          >
        </ul>
        <Authentication />
      </div>
    </nav>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import useAuthentication from "../useAuthentication";

import Authentication from "./AuthenticationComponent.vue";

const { isAuthenticated } = useAuthentication();

const links = [
  { label: "Home", route: "/" },
  { label: "Products", route: "/products", authenticated: true },
  { label: "Categories", route: "categories", authenticated: true },
  { label: "Preselection", route: "preselection", authenticated: true },
  { label: "Contact", route: "contact" },
];

const filteredLinks = computed(() => {
  return links.filter((item) => {
    if (item.authenticated && !isAuthenticated.value) {
      return false;
    }
    return true;
  });
});

const navbarContent = ref(null)
const hideNavbarmenu = () => {
  navbarContent.value.classList.remove('show')
}
</script>

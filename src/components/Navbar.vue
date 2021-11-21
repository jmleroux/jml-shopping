<template>
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h1 class="navbar-brand">JML Shopping</h1>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <router-link
            v-for="item in filteredLinks"
            :key="item.label"
            :to="item.route"
            class="nav-item nav-link"
            >{{ item.label }}</router-link
          >
        </ul>
        <Authentication />
      </div>
    </nav>
  </div>
</template>

<script setup>
import { computed } from "@vue/reactivity";
import useAuthentication from "../useAuthentication";

import Authentication from "./Authentication.vue";

const { isAuthenticated } = useAuthentication();

const links = [
  { label: "Home", route: "/" },
  { label: "Products", route: "/products", authenticated: true },
  { label: "Categories", route: "categories", authenticated: true },
  { label: "Preselection", route: "preselection", authenticated: true },
  { label: "About", route: "about" },
  { label: "Contact", route: "about" },
];

const filteredLinks = computed(() => {
  return links.filter((item) => {
    if (item.authenticated && !isAuthenticated.value) {
      return false;
    }
    return true;
  });
});
</script>

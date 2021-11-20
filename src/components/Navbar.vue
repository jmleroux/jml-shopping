<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand tag="h1" class="mb-0">JML Shopping</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <router-link
            v-for="item in visibleLinks"
            :key="item.label"
            :to="item.route"
            class="nav-item nav-link"
            >{{ item.label }}</router-link
          >
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: "navbar",
  data: function () {
    return {
      links: [
        { label: "Home", route: "/" },
        { label: "Products", route: "/products", authenticated: true },
        { label: "Categories", route: "categories", authenticated: true },
        { label: "Preselection", route: "preselection", authenticated: true },
        { label: "About", route: "about" },
        { label: "Contact", route: "about" },
      ],
    };
  },
  computed: {
    visibleLinks() {
      const filtered = this.links
      return filtered
    },
  },
};
</script>

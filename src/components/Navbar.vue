<template>
  <div>
    <v-app-bar dark color="deep-purple" clipped-left app>
      <v-toolbar-title class="white--text">JML Shopping</v-toolbar-title
      >
      <v-btn
        v-for="(route, label) in links"
        :key="label"
        color="white"
        text
        rounded
        class="my-2"
        :to="route"
      >
        {{ label }}
      </v-btn>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  name: "navbar",
  data: function () {
    return {
      links: {
        Home: "/",
        Categories: "categories",
        Preselection: "preselection",
        About: "about",
        Contact: "about",
      },
    };
  },
};
</script>

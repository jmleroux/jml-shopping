<template>
  <div>
    <v-app-bar dark color="deep-purple" clipped-left app>
      <v-toolbar-title @click="goHome" class="white--text">JML Shopping</v-toolbar-title>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  name: 'navbar',
  data: function () {
    return {
      drawer: false
    }
  },
  methods: {
    goHome () {
      this.$router.replace('/')
    }
  }
}
</script>

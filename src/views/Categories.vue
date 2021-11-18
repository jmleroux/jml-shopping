<template>
  <div class="home">
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">Category</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in categories" :key="item.id">
            <td class="text-left">{{ item.label }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import db from "../db";
import { ref, onValue } from "firebase/database";

const categoriesRef = ref(db, "categories");

export default {
  name: "Categories",
  data: () => ({
    categories: [],
  }),
  created() {
    onValue(categoriesRef, (snapshot) => {
      this.categories = [];
      snapshot.forEach((doc) => {
        this.categories.push(doc.val());
      });
    });
  },
};
</script>

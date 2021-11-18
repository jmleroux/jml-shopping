<template>
  <div class="home">
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">Product</th>
            <th class="text-left">Categorie</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in preselection" :key="item.id">
            <td class="text-left">{{ item.label }}</td>
            <td class="text-left">{{ categoryLabel(item.category) }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import db from "../db"
import { ref, onValue } from "firebase/database"
import useCategories from "../useCategories"

const preselectionRef = ref(db, "preselection")
const categoriesRef = useCategories.categoriesRef

export default {
  name: "Preselection",
  data: () => ({
    categories: [],
    preselection: [],
  }),
  created() {
    onValue(categoriesRef, (snapshot) => {
      this.categories = [];
      snapshot.forEach((doc) => {
        this.categories.push(doc.val());
      });
    });
    onValue(preselectionRef, (snapshot) => {
      this.preselection = [];
      snapshot.forEach((doc) => {
        this.preselection.push(doc.val());
      });
    });
  },
  methods: {
    categoryLabel(categoryId) {
      return useCategories.categoryLabel(categoryId, this.categories)
    }
  }
};
</script>

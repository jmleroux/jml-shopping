<template>
  <div class="categories">
    <h1>Categories</h1>
    <v-form ref="form" v-on:submit.prevent="saveCategory">
      <v-row>
        <v-col><v-text-field v-model="category.label" label="Label" /></v-col>
        <v-col><v-btn class="mr-4" type="submit">Submit</v-btn></v-col>
      </v-row>
    </v-form>
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
            <td>
              <v-btn @click="() => removeCategory(item.id)">
                <v-icon left> mdi-delete </v-icon>
                Remove
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import { onValue } from "firebase/database";
import useCategories from "../useCategories";

const categoriesRef = useCategories.categoriesRef;
const emptyCategory = {
  id: null,
  label: null,
};

export default {
  name: "Categories",
  data: () => ({
    category: { ...emptyCategory },
    categories: [],
  }),
  created() {
    onValue(categoriesRef, (snapshot) => {
      this.categories = [];
      snapshot.forEach((doc) => {
        this.categories.push({
          id: doc.ref.key,
          label: doc.val().label,
        });
      });
    });
  },
  methods: {
    saveCategory() {
      useCategories.saveCategory(this.category);
      this.category = { ...emptyCategory };
    },
    removeCategory(categoryId) {
      useCategories.removeCategory(categoryId);
    },
  },
};
</script>

<template>
  <div class="preselection">
    <h1>Preselection</h1>
    <v-form ref="form" v-on:submit.prevent="saveItem">
      <v-row>
        <v-col>
          <v-text-field v-model="newItem.label" label="Product" />
        </v-col>
        <v-col>
          <v-select
            v-model="newItem.category"
            :items="categories"
            item-text="label"
            item-value="id"
            label="Category"
            data-vv-name="select"
            required
          />
        </v-col>
        <v-col><v-btn class="mr-4" type="submit">Submit</v-btn></v-col>
      </v-row>
    </v-form>

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
            <td>
              <v-btn @click="() => removeItem(item.id)">
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
import { ref, onValue, child, set, remove } from "firebase/database";
import slugify from "slugify"
import db from "@/db";
import useCategories from "@/useCategories";

const preselectionRef = ref(db, "preselection");
const categoriesRef = useCategories.categoriesRef;
const emptyItem = {
  id: null,
  label: null,
  category: null,
};

export default {
  name: "Preselection",
  data: () => ({
    newItem: { ...emptyItem },
    products: [],
    categories: [],
    preselection: [],
  }),
  created() {
    onValue(categoriesRef, (snapshot) => {
      this.categories = [];
      snapshot.forEach((doc) => {
        useCategories.addDocToCategories(doc, this.categories);
      });
    });
    onValue(preselectionRef, (snapshot) => {
      this.preselection = [];
      snapshot.forEach((doc) => {
        this.preselection.push({
          id: doc.ref.key,
          label: doc.val().label,
          category: doc.val().category,
        });
      });
    });
  },
  methods: {
    categoryLabel(categoryId) {
      return useCategories.categoryLabel(categoryId, this.categories);
    },
    saveItem() {
      const newRef = child(preselectionRef, slugify(this.newItem.label));
      set(newRef, {
        label: this.newItem.label,
        category: this.newItem.category,
      });
    },
    removeItem(itemId) {
      const itemRef = ref(db, "preselection/" + itemId);
      remove(itemRef);
    },
  },
};
</script>

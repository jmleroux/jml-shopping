<template>
  <div class="home">
    <h1>Products</h1>
    <v-form ref="form" v-on:submit.prevent="onSubmit">
      <v-row>
        <v-col><v-text-field v-model="product.label" label="Label" /></v-col>
        <v-col>
          <v-select
            v-model="product.category"
            :items="categories"
            item-text="label"
            item-value="id"
            label="Category"
            data-vv-name="select"
            required
          />
        </v-col>
        <v-col
          ><v-text-field v-model="product.quantity" label="Quantity"
        /></v-col>
        <v-col><v-btn class="mr-4" type="submit">Submit</v-btn></v-col>
      </v-row>
    </v-form>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">Label</th>
            <th class="text-left">Category</th>
            <th class="text-left">Quantity</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in products" :key="item.id">
            <td class="text-left">{{ item.label }}</td>
            <td class="text-left">{{ categoryLabel(item.category) }}</td>
            <td class="text-left">{{ item.quantity }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import { onValue, ref, push, set } from "firebase/database"
import db from "../db"
import useCategories from "../useCategories"

const productsRef = ref(db, "products")
const categoriesRef = ref(db, "categories")

export default {
  name: "Home",
  data: () => ({
    product: {
      id: null,
      label: null,
      category: null,
      quantity: null,
    },
    products: [],
    categories: [],
  }),
  created() {
    onValue(productsRef, (snapshot) => {
      this.products = [];
      snapshot.forEach((doc) => {
        this.addProduct(doc.val());
      });
    });
    onValue(categoriesRef, (snapshot) => {
      this.categories = [];
      snapshot.forEach((doc) => {
        this.categories.push(doc.val());
      });
    });
  },
  methods: {
    addProduct(values) {
      this.products.push({
        label: values.label,
        category: values.category,
        quantity: values.quantity,
      });
    },
    addCategory(values) {
      this.categories.push({
        label: values.label,
      });
    },
    saveProduct() {
      const newPostRef = push(productsRef);
      set(newPostRef, {
        label: this.product.label,
        category: this.product.category,
        quantity: this.product.quantity,
      });
    },
    categoryLabel(categoryId) {
      return useCategories.categoryLabel(categoryId, this.categories);
    },
    onSubmit() {
      this.saveProduct();
    },
  },
}
</script>

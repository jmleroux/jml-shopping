<template>
  <div class="home">
    <h1>Products</h1>
    <b-form ref="form" v-on:submit.prevent="saveProduct" inline>
      <b-form-input
        v-model="product.label"
        placeholder="Enter your name"
      ></b-form-input>
      <b-form-select
        class="mb-3"
        v-model="product.category"
        :options="categories"
        text-field="label"
        value-field="id"
      />
      <b-form-input
        v-model="product.quantity"
        placeholder="Quantity"
      ></b-form-input>
      <b-button class="mr-4" type="submit">Submit</b-button>
    </b-form>
    <table class="table">
      <thead>
        <tr>
          <th class="text-left">Label</th>
          <th class="text-left">Category</th>
          <th class="text-left">Quantity</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in products" :key="item.id">
          <td class="text-left">{{ item.label }}</td>
          <td class="text-left">{{ categoryLabel(item.category) }}</td>
          <td class="text-left">{{ item.quantity }}</td>
          <td>
            <b-button @click="() => removeProduct(item.id)">
              <b-icon-trash />
              Remove
            </b-button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { onValue } from "firebase/database";
import useProducts from "../useProducts";
import useCategories from "../useCategories";

const productsRef = useProducts.productsRef;
const categoriesRef = useCategories.categoriesRef;
const emptyProduct = {
  id: null,
  label: null,
  category: null,
  quantity: null,
};

export default {
  name: "Products",
  data: () => ({
    product: { ...emptyProduct },
    products: [],
    categories: [],
  }),
  created() {
    onValue(productsRef, (snapshot) => {
      this.products = [];
      snapshot.forEach((doc) => {
        useProducts.addDocToProducts(doc, this.products);
      });
    });
    onValue(categoriesRef, (snapshot) => {
      this.categories = [];
      snapshot.forEach((doc) => {
        useCategories.addDocToCategories(doc, this.categories);
      });
    });
  },
  methods: {
    saveProduct() {
      useProducts.saveProduct(this.product);
      this.product = { ...emptyProduct };
    },
    removeProduct(productId) {
      useProducts.removeProduct(productId);
    },
    categoryLabel(categoryId) {
      return useCategories.categoryLabel(categoryId, this.categories);
    },
  },
};
</script>

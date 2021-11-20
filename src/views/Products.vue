<template>
  <div class="home">
    <h1>Products</h1>
    <v-form ref="form" v-on:submit.prevent="saveProduct">
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
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in products" :key="item.id">
            <td class="text-left">{{ item.label }}</td>
            <td class="text-left">{{ categoryLabel(item.category) }}</td>
            <td class="text-left">{{ item.quantity }}</td>
            <td>
              <v-btn @click="() => removeProduct(item.id)">
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

<template>
  <div class="home">
    <h1>Products</h1>

    <form
      class="row gy-2 gx-3 align-items-center"
      v-on:submit.prevent="saveProduct"
    >
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Label></label>
        <input
          v-model="product.label"
          type="text"
          class="form-control"
          id="autoSizingInput"
          placeholder="Label"
        />
      </div>
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingSelect">Category</label>
        <select
          class="form-select"
          id="autoSizingSelect"
          v-model="product.category"
          text-field="label"
          value-field="id"
        >
          <option
            v-for="category in categories.items"
            :key="category.id"
            :value="category.id"
          >
            {{ category.label }}
          </option>
        </select>
      </div>
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Quantity></label>
        <input
          v-model="product.quantity"
          type="text"
          class="form-control"
          id="autoSizingInput"
          placeholder="Quantity"
        />
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    <table class="table">
      <thead>
        <tr>
          <th>Label</th>
          <th>Category</th>
          <th>Quantity</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in products.items" :key="item.id">
          <td>{{ item.label }}</td>
          <td>{{ categoryLabel(item.category) }}</td>
          <td>{{ item.quantity }}</td>
          <td>
            <button
              class="btn sm-btn btn-secondary"
              @click="() => removeProduct(item.id)"
            >
              <i class="bi bi-trash" />
              Remove
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import useProducts from "../useProducts";
import useCategories from "../useCategories";

const { product, products, saveProduct, removeProduct } = useProducts();
const { categories, categoryLabel } = useCategories();

</script>

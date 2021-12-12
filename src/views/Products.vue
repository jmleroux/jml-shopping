<template>
  <div class="home">
    <h1>Products</h1>

    <form
      class="row gy-2 gx-3 align-items-center"
      v-on:submit.prevent="addProduct"
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
    <hr />
    <table class="table">
      <thead>
        <tr>
          <th @click="changeSort('label')">Label <i :class="sortIconClass('label')" /></th>
          <th @click="changeSort('category')">Category <i :class="sortIconClass('category')" /></th>
          <th>Quantity</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in sortedItems" :key="item.id">
          <td>{{ item.label }}</td>
          <td>{{ categoryLabel(item.category) }}</td>
          <td>{{ item.quantity }}</td>
          <td>
            <button
              class="btn sm-btn btn-secondary me-1"
              @click="() => removeProduct(item.id)"
            >
              <i class="bi bi-trash" /></button>
            <button
              class="btn sm-btn btn-secondary"
              @click="() => edit(item)"
            >
              <i class="bi bi-pencil-square" /></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed, ref } from "@vue/reactivity";

import useProducts from "../useProducts";
import useCategories from "../useCategories";

const { emptyProduct, product, products, saveProduct, removeProduct } = useProducts();
const { categories, categoryLabel } = useCategories();
const sortField = ref('label')
const sortDirection = ref('asc')

const addProduct = () => {
  saveProduct(product)
  Object.assign(product, emptyProduct)
}

const sortedItems = computed(() => {
  return products.items.sort((item1, item2) => {
    const label1 = item1[sortField.value].toLowerCase()
    const label2 = item2[sortField.value].toLowerCase()

    const result = label1 < label2 ? -1 : label1 > label2 ? 1 : 0;

    return 'asc' === sortDirection.value ? result : result * -1
  })
})

const changeSort = fieldName => {
  sortField.value = fieldName
  sortDirection.value = 'asc' === sortDirection.value ? 'desc' : 'asc'
}

const sortIconClass = fieldName => {
  const iconClass = 'asc' === sortDirection.value ? 'bi bi-caret-down' : 'bi bi-caret-up'

  return fieldName === sortField.value ? iconClass : ''
}

const edit = item => {
  Object.assign(product, item)
}
</script>

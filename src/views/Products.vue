<template>
  <div class="home">
    <h1>Products</h1>
    <form autocomplete="off"
      class="row gy-2 gx-3 align-items-center"
      v-on:submit.prevent="addProduct"
    >
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Label></label>
        <input
          ref="inputLabel"
          autocomplete="off"
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
        <button type="button" class="btn btn-secondary ms-1" @click="cancelEdit">Cancel</button>
      </div>
    </form>
    <hr />
    <p class="alert alert-info alert-dismissible fade show" role="alert">
      You can check/uncheck a product by double clicking on the row.
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      ></button>
    </p>

    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th @click="changeSort('label')">
            Label <i :class="sortIconClass('label')" />
          </th>
          <th @click="changeSort('category')">
            Category <i :class="sortIconClass('category')" />
          </th>
          <th>Quantity</th>
          <th>
            Show checked items <input type="checkbox" v-model="showChecked" />
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in filteredItems"
          :key="item.id"
          :class="productClass(item.checked)"
          @dblclick="() => checkProduct(item)"
        >
          <td>{{ item.label }}</td>
          <td>{{ categoryLabel(item.category) }}</td>
          <td>{{ item.quantity }}</td>
          <td class="buttons">
            <button
              class="btn btn-sm btn-danger"
              @click="() => removeProduct(item.id)"
            >
              <i class="bi bi-trash" />
            </button>
            <button class="btn btn-sm btn-warning" @click="() => edit(item)">
              <i class="bi bi-pencil-square" />
            </button>
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

const {
  emptyProduct,
  checkProduct,
  product,
  products,
  saveProduct,
  removeProduct,
} = useProducts();
const { categories, categoryLabel } = useCategories();
const sortField = ref("category");
const sortDirection = "asc";
const showChecked = ref(true);
const inputLabel = ref(null);

const addProduct = () => {
  saveProduct(product);
  Object.assign(product, emptyProduct);
  inputLabel.value.focus()
};

const sortedItems = computed(() => {
  return products.items.sort((item1, item2) => {
    const value1 = item1[sortField.value]?.toLowerCase();
    const value2 = item2[sortField.value]?.toLowerCase();

    return !value1 ? -1 : value1 < value2 ? -1 : value1 > value2 ? 1 : 0;
  });
});

const filteredItems = computed(() => {
  return sortedItems.value.filter((item) => {
    return showChecked.value || false === item.checked;
  });
});

const changeSort = (fieldName) => {
  sortField.value = fieldName;
};

const sortIconClass = (fieldName) => {
  const iconClass =
    "asc" === sortDirection ? "bi bi-caret-down" : "bi bi-caret-up";

  return fieldName === sortField.value ? iconClass : "";
};

const edit = (item) => {
  Object.assign(product, item);
};

const cancelEdit = () => {
  Object.assign(product, emptyProduct);
};

const productClass = (checked) => {
  return true === checked ? "stroke" : "";
};
</script>

<style lang="scss" scoped>
.stroke {
  text-decoration: line-through;
  opacity: 0.25;
}

.buttons {
  width: 100px;
}
</style>

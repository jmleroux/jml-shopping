<template>
  <div class="home">
    <h1>
      Products
      <button v-if="!showProductForm" type="button" class="btn btn-secondary ms-1" @click="toggleProductForm">
        Show form
      </button>
    </h1>
    <form autocomplete="off" class="row gy-2 gx-3 align-items-center" v-on:submit.prevent="addProduct"
      v-if="showProductForm">
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Label></label>
        <input ref="inputLabel" autocomplete="off" v-model="product.label" type="text" class="form-control"
          id="autoSizingInput" placeholder="Label" />
      </div>
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingSelect">Category</label>
        <select class="form-select" id="autoSizingSelect" v-model="product.category" text-field="label"
          value-field="id">
          <option v-for="category in categories.items" :key="category.id" :value="category.id">
            {{ category.label }}
          </option>
        </select>
      </div>
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Quantity></label>
        <input v-model="product.quantity" type="text" class="form-control" id="autoSizingInput"
          placeholder="Quantity" />
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary ms-1" @click="cancelEdit">
          Cancel
        </button>
        <button type="button" class="btn btn-secondary ms-1" @click="toggleProductForm">
          Hide form
        </button>
      </div>
    </form>
    <hr />
    <p v-if="showProductHint" id="product-hint" class="alert alert-info alert-dismissible fade show" role="alert">
      You can check/uncheck a product by double clicking on the row.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
          <th v-if="listHasQuantities">Quantity</th>
          <th>
            Show checked items <input type="checkbox" v-model="showChecked" />
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in filteredItems" :key="item.id" :class="productClass(item.checked)"
          @dblclick="() => checkProduct(item)">
          <td>{{ item.label }}</td>
          <td>{{ categoryLabel(item.category) }}</td>
          <td v-if="listHasQuantities">{{ item.quantity }}</td>
          <td class="buttons">
            <button class="btn btn-sm btn-danger" @click="() => removeProduct(item.id)">
              <i class="bi bi-trash" />
            </button>
            <button class="btn btn-sm btn-warning" @click="() => edit(item)">
              <i class="bi bi-pencil-square" />
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <button class="btn btn-warning delete-button" @click="() => deleteCheckedProducts()">
      <i class="bi bi-check-circle" /> Delete checked products
    </button>
    <button class="btn btn-danger delete-button" @click="() => deleteAllProducts()">
      <i class="bi bi-trash" /> Delete all products
    </button>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { onMounted } from "vue";

import store from "../store";
import useProducts from "../useProducts";
import useCategories from "../useCategories";
import useSort from "../useSort";

const { showProductHint, showProductForm, showChecked, hideProductHint, toggleProductForm } =
  store();

const {
  emptyProduct,
  checkProduct,
  product,
  products,
  saveProduct,
  removeProduct,
  deleteAllProducts,
  deleteCheckedProducts,
  listHasQuantities,
} = useProducts();
const { categories, categoryLabel } = useCategories()
const { sortField, sortIconClass, changeSort } = useSort("category")

const inputLabel = ref(null)

const addProduct = () => {
  saveProduct(product);
  Object.assign(product, emptyProduct);
  inputLabel.value.focus();
};

const sortedItems = computed(() => {
  const sorted = {...products}
  return sorted.items.sort((item1, item2) => {
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

const edit = (item) => {
  Object.assign(product, item);
};

const cancelEdit = () => {
  Object.assign(product, emptyProduct);
};

const productClass = (checked) => {
  return true === checked ? "stroke" : "";
};

onMounted(() => {
  const productHint = document.getElementById("product-hint");

  productHint?.addEventListener("close.bs.alert", function () {
    hideProductHint();
  });
});
</script>

<style lang="scss" scoped>
.stroke {
  text-decoration: line-through;
  opacity: 0.25;
}

.buttons {
  width: 100px;
}

.delete-button {
  margin-right: 1rem;
}
</style>

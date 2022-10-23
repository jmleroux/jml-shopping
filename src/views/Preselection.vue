<template>
  <div class="preselection">
    <h1>Preselection</h1>
    <p id="hint" class="alert alert-info alert-dismissible fade show" role="alert" v-if="showSelectionHint">
      Here is a list of the recurrent products that you can quickly add to the
      shopping list. Just check the desired products and add them at once to the
      list.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </p>
    <form class="row gy-2 gx-3 align-items-center" v-on:submit.prevent="saveItem">
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Label></label>
        <input v-model="newItem.label" type="text" class="form-control" id="autoSizingInput" placeholder="Product" />
      </div>
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingSelect">Category</label>
        <select class="form-select" id="autoSizingSelect" v-model="newItem.category">
          <option v-for="category in categories.items" :key="category.id" :value="category.id">
            {{ category.label }}
          </option>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <hr />
    <table class="table">
      <thead>
        <tr>
          <th>
            <button class="btn btn-primary" v-on:click="addSelectionToProducts" title="Add to list">
              <i class="bi bi-cart" /></button>
          </th>
          <th class="text-left" @click="changeSort('label')">
            Product <i :class="sortIconClass('label')" />
          </th>
          <th class="text-left" @click="changeSort('category')">
            Category <i :class="sortIconClass('category')" />
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in sortedItems" :key="item.id">
          <td class="text-left">
            <input class="form-check-input" type="checkbox" :value="item" v-model="selection.items" />
          </td>
          <td class="text-left">{{ item.label }}</td>
          <td class="text-left">{{ categoryLabel(item.category) }}</td>
          <td class="buttons">
            <button class="btn btn-sm btn-danger" @click="() => removeItem(item.id)">
              <i class="bi bi-trash" /></button>
            <button class="btn btn-sm btn-warning" @click="() => edit(item)">
              <i class="bi bi-pencil-square" /></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed, reactive } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import { ref, onValue, child, set, remove } from "firebase/database";
import slugify from "slugify";

import db from "@/db";
import store from '../store'
import useCategories from "@/useCategories";
import useProducts from "@/useProducts";
import useSort from "@/useSort";

const { showSelectionHint, hideSelectionHint } = store();
const { sortField, sortIconClass, changeSort } = useSort("category")

const preselectionRef = ref(db, "preselection");
const emptyItem = {
  id: null,
  label: null,
  category: null,
};

const { categories, categoryLabel } = useCategories();
const { saveProduct } = useProducts();

const newItem = reactive({ ...emptyItem });
const preselection = reactive({ items: [] });
const selection = reactive({ items: [] });

onValue(preselectionRef, (snapshot) => {
  preselection.items = [];
  snapshot.forEach((doc) => {
    preselection.items.push({
      id: doc.ref.key,
      label: doc.val().label,
      category: doc.val().category,
    });
  });
});

const saveItem = () => {
  const newItemId = newItem.id || slugify(newItem.label, { lower: true })
  const newRef = child(preselectionRef, newItemId);
  set(newRef, {
    label: newItem.label,
    category: newItem.category,
  });
  Object.assign(newItem, { ...emptyItem });
};

const removeItem = (itemId) => {
  const itemRef = ref(db, "preselection/" + itemId);
  remove(itemRef);
};

const addSelectionToProducts = () => {
  selection.items.forEach((item) => {
    saveProduct(item);
  });
  Object.assign(selection, { items: [] });
};

const sortedItems = computed(() => {
  return preselection.items.sort((item1, item2) => {
    const value1 = item1[sortField.value]?.toLowerCase();
    const value2 = item2[sortField.value]?.toLowerCase();

    return !value1 ? -1 : value1 < value2 ? -1 : value1 > value2 ? 1 : 0;
  });
});

const edit = item => {
  Object.assign(newItem, item)
}

onMounted(() => {
  const hint = document.getElementById("hint");

  hint?.addEventListener("close.bs.alert", function () {
    hideSelectionHint()
  });
})
</script>

<style lang="scss" scoped>
.buttons {
  width: 100px;
}
</style>

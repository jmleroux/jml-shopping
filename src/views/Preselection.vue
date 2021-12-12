<template>
  <div class="preselection">
    <h1>Preselection</h1>

    <p class="alert alert-info alert-dismissible fade show" role="alert">
      Here is a list of the recurrent products that you can quickly add to the
      shopping list. Just check the desired products and add them at once to the
      list.
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </p>

    <form
      class="row gy-2 gx-3 align-items-center"
      v-on:submit.prevent="saveItem"
    >
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Label></label>
        <input
          v-model="newItem.label"
          type="text"
          class="form-control"
          id="autoSizingInput"
          placeholder="Product"
        />
      </div>
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingSelect">Category</label>
        <select
          class="form-select"
          id="autoSizingSelect"
          v-model="newItem.category"
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
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <hr/>
    <table class="table">
      <thead>
        <tr>
          <th>
            <button class="btn btn-primary" v-on:click="addSelectionToProducts" title="Add to list">
              <i class="bi bi-cart" /></button>
          </th>
          <th class="text-left">Product</th>
          <th class="text-left">Categorie</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in filteredItems" :key="item.id">
          <td class="text-left">
            <input
              class="form-check-input"
              type="checkbox"
              :value="item"
              v-model="selection.items"
            />
          </td>
          <td class="text-left">{{ item.label }}</td>
          <td class="text-left">{{ categoryLabel(item.category) }}</td>
          <td>
            <button
              class="btn btn-sm btn-danger m-1"
              @click="() => removeItem(item.id)"
            >
              <i class="bi bi-trash" /></button>
            <button
              class="btn btn-sm btn-warning m-1"
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
import { computed, reactive } from "@vue/reactivity";
import { ref, onValue, child, set, remove } from "firebase/database";
import slugify from "slugify";

import db from "@/db";
import useCategories from "@/useCategories";
import useProducts from "@/useProducts";

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

const filteredItems = computed(() => {
  return preselection.items.sort((item1, item2) => {
    const label1 = item1.label.toLowerCase()
    const label2 = item2.label.toLowerCase()
    const category1 = item1.category.toLowerCase()
    const category2 = item2.category.toLowerCase()

    return category1 < category2 ? -1 : category1 > category2 ? 1 : label1 < label2 ? -1 : label1 > label2 ? 1 : 0;
  })
})


const edit = item => {
  Object.assign(newItem, item)
}
</script>

<template>
  <div class="categories">
    <h1>Categories</h1>
    <form
      class="row gy-2 gx-3 align-items-center"
      v-on:submit.prevent="saveCategory"
    >
      <div class="col-auto">
        <label class="visually-hidden" for="autoSizingInput">Label></label>
        <input
          v-model="category.label"
          type="text"
          class="form-control"
          id="autoSizingInput"
          placeholder="Label"
        />
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th>Category</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in categories.items" :key="item.id">
          <td>{{ item.label }}</td>
          <td>
            <button
              class="btn sm-btn btn-secondary"
              @click="() => removeCategory(item.id)"
            >
              <i class="bi bitrash" />
              Remove
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { reactive } from "@vue/reactivity";
import { onValue } from "firebase/database";
import useCategories from "../useCategories";

const categoriesRef = useCategories.categoriesRef;
const emptyCategory = {
  id: null,
  label: null,
};

const category = reactive({ ...emptyCategory });
const categories = reactive({ items: [] });

onValue(categoriesRef, (snapshot) => {
  categories.items = [];
  snapshot.forEach((doc) => {
    categories.items.push({
      id: doc.ref.key,
      label: doc.val().label,
    });
  });
});

const saveCategory = () => {
  useCategories.saveCategory(category);
  Object.assign(category, { ...emptyCategory });
};

const removeCategory = (categoryId) => {
  useCategories.removeCategory(categoryId);
};
</script>

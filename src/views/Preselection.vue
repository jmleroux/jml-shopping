<template>
  <div class="preselection">
    <h1>Preselection</h1>

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


    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th class="text-left">Product</th>
          <th class="text-left">Categorie</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in preselection.items" :key="item.id">
          <td class="text-left">
            <input class="form-check-input" type="checkbox" value="">
          </td>
          <td class="text-left">{{ item.label }}</td>
          <td class="text-left">{{ categoryLabel(item.category) }}</td>
          <td>
            <button class="btn sm-btn btn-secondary" @click="() => removeItem(item.id)">
              <i class="bi bi-trash"/>
              Remove
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onValue, child, set, remove } from "firebase/database";
import slugify from "slugify";
import db from "@/db";
import useCategories from "@/useCategories";
import { reactive } from "@vue/reactivity";

const preselectionRef = ref(db, "preselection");
const categoriesRef = useCategories.categoriesRef;
const emptyItem = {
  id: null,
  label: null,
  category: null,
};

const newItem = reactive({ ...emptyItem });
const categories = reactive({ items: [] });
const preselection = reactive({ items: [] });

onValue(categoriesRef, (snapshot) => {
  categories.items = [];
  snapshot.forEach((doc) => {
    useCategories.addDocToCategories(doc, categories.items);
  });
});
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

const categoryLabel = (categoryId) => {
  return useCategories.categoryLabel(categoryId, categories.items);
}

const saveItem = () => {
  const newRef = child(preselectionRef, slugify(newItem.label));
  set(newRef, {
    label: newItem.label,
    category: newItem.category,
  });
}

const removeItem = (itemId) => {
  const itemRef = ref(db, "preselection/" + itemId);
  remove(itemRef);
}
</script>

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
    <hr />
    <table class="table">
      <thead>
        <tr>
          <th>Category</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in filteredItems" :key="item.id">
          <td>{{ item.label }}</td>
          <td>
            <button
              class="btn sm-btn btn-secondary me-1"
              @click="() => removeCategory(item.id)"
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
import { computed } from "@vue/reactivity";
import useCategories from "../useCategories";

const { category, categories, saveCategory, removeCategory } = useCategories()

const filteredItems = computed(() => {
  return categories.items.sort((item1, item2) => {
    const label1 = item1.label.toLowerCase()
    const label2 = item2.label.toLowerCase()

    return label1 < label2 ? -1 : label1 > label2 ? 1 : 0;
  })
})

const edit = item => {
  Object.assign(category, item)
}

</script>

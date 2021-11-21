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
import useCategories from "../useCategories";

const { category, categories, saveCategory, removeCategory } = useCategories()

</script>

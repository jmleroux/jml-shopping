import { ref, set, child, onValue } from "firebase/database"
import slugify from "slugify";
import { reactive } from "@vue/reactivity";

import db, { removeById } from "@/db"

export default function useCategories() {

  const categoriesRef = ref(db, "categories");

  const category = reactive({ ...emptyCategory });
  const categories = reactive({ items: [] });

  const emptyCategory = {
    id: null,
    label: null,
  };

  const saveCategory = () => {
    const newCategoryRef = child(categoriesRef, slugify(category.label, { lower: true }));
    set(newCategoryRef, {
      label: category.label,
    });
    Object.assign(category, { ...emptyCategory })
  }

  const removeCategory = categoryId => {
    removeById("categories/" + categoryId);
  }

  const categoryLabel = (categoryId) => {
    const found = categories.items.find(
      (category) => category.id == categoryId
    );
    return found?.label || "";
  }

  onValue(categoriesRef, (snapshot) => {
    categories.items = [];
    snapshot.forEach((doc) => {
      categories.items.push({
        id: doc.ref.key,
        label: doc.val().label,
      });
    });
  });

  return {
    category,
    categories,
    saveCategory,
    removeCategory,
    categoryLabel,
  };
}

import { ref, set, child, onValue } from "firebase/database"
import slugify from "slugify";
import { reactive } from "vue";

import db, { removeById } from "@/db"

export default function useCategories() {

  const categoriesRef = ref(db, "categories");

  const emptyCategory = {
    id: null,
    label: null,
  };

  const category = reactive({ ...emptyCategory });
  const categories = reactive({ items: [] });

  const saveCategory = () => {
    const categoryId = category.id || slugify(category.label, { lower: true })
    const newCategoryRef = child(categoriesRef, categoryId);
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

  onValue(categoriesRef,
    (snapshot) => {
      categories.items = [];
      snapshot.forEach((doc) => {
        categories.items.push({
          id: doc.ref.key,
          label: doc.val().label,
        });
      });
    },
    (error) => {
      console.log('Error reading categories')
      console.log(error)
    }
  );

  return {
    category,
    categories,
    saveCategory,
    removeCategory,
    categoryLabel,
  };
}

import { ref, set, remove, child } from "firebase/database"
import slugify from "slugify";
import db from "@/db"

const categoriesRef = ref(db, "categories");

const saveCategory = category => {
  const newCategoryRef = child(categoriesRef, slugify(category.label, { lower: true }));
  set(newCategoryRef, {
    label: category.label,
  });
}

const removeCategory = categoryId => {
  const categoryRef = ref(db, "categories/" + categoryId);
  remove(categoryRef);
}

const categoryLabel = (categoryId, categories) => {
  const found = categories.find(
    (category) => category.id == categoryId
  );
  return found?.label || "";
}

const addDocToCategories = (doc, categories) => {
  categories.push({
    id: doc.ref.key,
    label: doc.val().label,
  });
}


export default { categoriesRef, categoryLabel, saveCategory, removeCategory, addDocToCategories }

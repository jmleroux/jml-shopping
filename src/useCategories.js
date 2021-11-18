import db from "./db"
import { ref } from "firebase/database"

const categoriesRef = ref(db, "categories");

const categoryLabel = (categoryId, categories) => {
  const found = categories.find(
    (category) => category.id == categoryId
  );
  return found?.label || "";
}

export default { categoriesRef, categoryLabel }

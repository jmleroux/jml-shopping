import { ref, child, set, remove } from "firebase/database"
import slugify from "slugify";
import db from "./db"

const productsRef = ref(db, "products");

const saveProduct = product => {
  const newRef = child(productsRef, slugify(product.label));
  set(newRef, {
    label: product.label,
    category: product.category,
    quantity: product.quantity,
  });
}

const removeProduct = productId => {
  const productRef = ref(db, "products/" + productId);
  remove(productRef);
}

const addDocToProducts = (doc, products) => {
  products.push({
    id: doc.ref.key,
    label: doc.val().label,
    category: doc.val().category,
    quantity: doc.val().quantity,
  });
}

export default { productsRef, saveProduct, removeProduct, addDocToProducts }

import { ref, child, set, onValue } from "firebase/database"
import slugify from "slugify";
import db, { removeById } from "./db"
import { reactive } from "@vue/reactivity";

export default function useProducts() {

  const productsRef = ref(db, "products");

  const emptyProduct = {
    id: null,
    label: null,
    category: null,
    quantity: null,
  };

  const product = reactive({ ...emptyProduct });
  const products = reactive({ items: [] });

  const saveProduct = () => {
    const newRef = child(productsRef, slugify(product.label));
    set(newRef, {
      label: product.label,
      category: product.category,
      quantity: product.quantity,
    });
  }

  const removeProduct = productId => {
    removeById("products/" + productId);
  }

  onValue(productsRef, (snapshot) => {
    products.items = [];
    snapshot.forEach((doc) => {
      console.log(doc.ref.key)
      products.items.push({
        id: doc.ref.key,
        label: doc.val().label,
        category: doc.val().category,
        quantity: doc.val().quantity,
      })
    });
  });

  return {
    product,
    products,
    saveProduct,
    removeProduct,
  }
}

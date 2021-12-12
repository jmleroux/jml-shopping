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

  const saveProduct = (newProduct) => {
    const newProductId = newProduct.id || slugify(newProduct.label, { lower: true })
    const newRef = child(productsRef, newProductId);
    set(newRef, { ...emptyProduct, ...newProduct });
  }

  const removeProduct = productId => {
    removeById("products/" + productId);
  }

  onValue(
    productsRef,
    (snapshot) => {
      products.items = [];
      snapshot.forEach((doc) => {
        products.items.push({
          id: doc.ref.key,
          label: doc.val().label,
          category: doc.val().category,
          quantity: doc.val().quantity,
        })
      })
    },
    (error) => {
      console.log('Error reading products')
      console.log(error)
    }
  );

  return {
    emptyProduct,
    product,
    products,
    saveProduct,
    removeProduct,
  }
}

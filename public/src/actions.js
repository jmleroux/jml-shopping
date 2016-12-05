const uid = () => Math.random().toString(32).slice(2);

export function addProduct(name, category, quantity) {
    return {
        type: 'PRODUCT_ADD',
        data: {
            id: uid(),
            name,
            category,
            quantity
        }
    };
}

export function deleteProduct(id) {
    return {
        type: 'PRODUCT_DELETE',
        id: id
    }
}

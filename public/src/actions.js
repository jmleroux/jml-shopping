import "isomorphic-fetch";

const uid = () => Math.random().toString(32).slice(2);

const loginRequest = (username, password) => ({
    type: 'LOGIN_REQUEST',
    data: [username, password]
});

const loginResponse = (json) => ({
    type: 'LOGIN_RESPONSE',
    data: json
});

export const logout = () => ({
    type: 'LOGOUT',
    data: null
});

const listProductsRequest = () => ({
    type: 'PRODUCT_LIST_START',
    data: null
});

export const listProductsResponse = (json) => ({
    type: 'PRODUCT_LIST_RESPONSE',
    data: {
        products: json
    }
});

export const login = (username, password) => {
    return function (dispatch) {
        dispatch(loginRequest(username, password));
        fetch("api_dev.php/login", {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify({username: username, password: password})
        })
            .then(response => response.json())
            .then(json => {
                dispatch(loginResponse(json))
            });
    }
};

export const listProducts = () => {
    return function (dispatch) {
        dispatch(listProductsRequest());
        fetch("api_dev.php/products")
            .then(response => response.json())
            .then(json => {
                dispatch(listProductsResponse(json))
            });
    }
};

export const addProduct = (product) => ({
    type: 'PRODUCT_ADD',
    data: {
        id: uid(),
        name: product.name,
        category: product.category,
        quantity: product.quantity
    }
});

export const deleteProduct = (id) => ({
    type: 'PRODUCT_DELETE',
    id: id
});

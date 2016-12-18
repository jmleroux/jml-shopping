import "isomorphic-fetch";
import 'babel-polyfill';
import {apiBase} from './reducer';

const uid = () => Math.random().toString(32).slice(2);

export const login = (username, password) => {
    return dispatch => {
        dispatch(loginRequest());
        fetch(apiBase + "/login", {
            method: "POST",
            body: JSON.stringify({username: username, password: password})
        })
            .then(response => {
                response.json()
                    .then(result => {
                        dispatch(loginResponse(response.status, result))
                    })
                    .then(() => {
                        if (response.ok) {
                            dispatch(listProducts());
                        }
                    })
            });
    }
};

const loginRequest = () => ({
    type: 'LOGIN_REQUEST',
    data: null
});

const loginResponse = (status, content) => ({
    type: 'LOGIN_RESPONSE',
    status: status,
    data: content
});

export const logout = () => ({
    type: 'LOGOUT',
    data: null
});

export const listProducts = () => {
    return dispatch => {
        dispatch(listProductsRequest());

        fetch(apiBase + "/products", {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-AUTH-TOKEN': localStorage.getItem('jmlshopping.token')
            },
            method: "GET"
        })
            .then(response => {
                return response.json();
            })
            .then(json => {
                dispatch(listProductsResponse(json));
            })
            .then(() => {
                dispatch(listCategories());
            });
    }
};

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

export const addProduct = (product) => ({
    type: 'PRODUCT_ADD',
    data: {
        id: uid(),
        name: product.name,
        category_id: product.category_id,
        quantity: product.quantity
    }
});

export const deleteProduct = (product) => ({
    type: 'PRODUCT_DELETE',
    data: product
});


export const listCategories = () => {
    return function (dispatch) {
        dispatch(listCategoriesRequest());

        fetch(apiBase + "/categories", {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-AUTH-TOKEN': localStorage.getItem('jmlshopping.token')
            },
            method: "GET"
        })
            .then(response => {
                return response.json();
            })
            .then(json => {
                dispatch(listCategoriesResponse(json));
            });
    }
};

const listCategoriesRequest = () => ({
    type: 'CATEGORY_LIST_START',
    data: null
});

export const listCategoriesResponse = (json) => ({
    type: 'CATEGORY_LIST_RESPONSE',
    data: {
        categories: json
    }
});


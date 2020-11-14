import React, {createContext, useReducer} from 'react';
import apiProductSelection from "./apiProductSelection";
import {sortProducts} from "./utils";

const GET_LIST_SUCCESS = 'GET_LIST_SUCCESS';
const EDIT_PRODUCT = 'EDIT_PRODUCT';
const EDIT_CATEGORY = 'EDIT_CATEGORY';
const UPDATE_PRODUCTS = 'UPDATE_PRODUCTS';
const UPDATE_CATEGORIES = 'UPDATE_CATEGORIES';
const DELETE_PRODUCT_SUCCESS = 'DELETE_PRODUCT_SUCCESS';
const CLEAR_ALL_PRODUCT = 'CLEAR_ALL_PRODUCTS';
const ADD_SELECTION_TO_LIST = 'ADD_SELECTION_TO_LIST';
const EDIT_PRODUCT_SELECTION = 'EDIT_PRODUCT_SELECTION';
const UPDATE_PRODUCT_SELECTION = 'UPDATE_PRODUCT_SELECTION';
const DELETE_PRODUCT_SELECTION_SUCCESS = 'DELETE_PRODUCT_SELECTION_SUCCESS';

export const getListSuccess = (data, resource) => ({
    type: GET_LIST_SUCCESS,
    payload: {data},
    meta: {resource},
});

export const editProduct = (values) => ({
    type: EDIT_PRODUCT,
    payload: {values},
});

export const editCategory = (values) => ({
    type: EDIT_CATEGORY,
    payload: {values},
});

export const updateProducts = () => ({
    type: UPDATE_PRODUCTS,
});

export const updateProductSelection = () => ({
    type: UPDATE_PRODUCT_SELECTION,
});

export const updateCategories = () => ({
    type: UPDATE_CATEGORIES,
});

export const deleteProductSuccess = (id) => ({
    type: DELETE_PRODUCT_SUCCESS,
    payload: {id},
});

export const deleteCategorySuccess = (id) => ({
    type: 'DELETE_CATEGORY_SUCCESS',
    payload: {id},
});

export const clearAllProducts = (id) => ({
    type: CLEAR_ALL_PRODUCT,
    payload: {id},
});

export const addSelectionToList = (ids) => ({
    type: ADD_SELECTION_TO_LIST,
    payload: ids
});

export const editProductSelection = (values) => ({
    type: EDIT_PRODUCT_SELECTION,
    payload: {values},
});

export const deleteProductSelectionSuccess = (id) => ({
    type: DELETE_PRODUCT_SELECTION_SUCCESS,
    payload: {id},
});

export const authSuccess = (authValues) => ({
    type: 'AUTH_SUCCESS',
    payload: authValues,
});

const initialState = {
    isAuthenticated: false,
    token: null,
    username: null,
    avatar: null,
    product: {
        id: null,
        name: '',
        quantity: 0,
        category_id: null,
    },
    category: {
        id: null,
        name: '',
    },
    currentProductSelection: {
        id: null,
        name: '',
        category_id: null,
    },
    categories: [],
    products: [],
    productSelection: [],
};

const store = createContext(initialState);
const {Provider} = store;

const StateProvider = ({children}) => {
    const [state, dispatch] = useReducer((state, action) => {
        switch (action.type) {
            case GET_LIST_SUCCESS: {
                const {resource} = action.meta;
                const {data} = action.payload;
                return {
                    ...state,
                    [resource]: data,
                };
            }
            case EDIT_PRODUCT: {
                const {values: product} = action.payload;
                product.quantity = parseInt(product.quantity);
                return {
                    ...state,
                    product: product,
                };
            }
            case EDIT_PRODUCT_SELECTION: {
                const {values: product} = action.payload;
                return {
                    ...state,
                    currentProductSelection: product,
                };
            }
            case EDIT_CATEGORY: {
                const {values} = action.payload;
                return {
                    ...state,
                    category: values,
                };
            }
            case UPDATE_PRODUCTS: {
                const currentProduct = state.product;
                const products = state.products.filter(product => product.id !== currentProduct.id);
                products.push(state.product);
                sortProducts(state, products);
                return {
                    ...state,
                    product: initialState.product,
                    products: products,
                };
            }
            case UPDATE_PRODUCT_SELECTION: {
                const currentProduct = state.currentProductSelection;
                const productSelection = state.productSelection.filter(product => product.id !== currentProduct.id);
                productSelection.push(currentProduct);
                productSelection.sort((p1, p2) => {
                    return p1.name.toLowerCase() > p2.name.toLowerCase() ? 1 : -1;
                });
                return {
                    ...state,
                    currentProductSelection: initialState.currentProductSelection,
                    productSelection: productSelection,
                };
            }
            case ADD_SELECTION_TO_LIST: {
                apiProductSelection.addProductSelectionToList(
                    state,
                    {ids: action.payload}
                )
                return state;
            }
            case UPDATE_CATEGORIES: {
                const currentCategory = state.category;
                let categories = state.categories;
                if (currentCategory.id) {
                    categories = state.categories.filter(category => category.id !== currentCategory.id);
                }
                categories.push(currentCategory);
                categories.sort((p1, p2) => {
                    return p1.name.toLowerCase() > p2.name.toLowerCase() ? 1 : -1;
                });
                return {
                    ...state,
                    category: initialState.category,
                    categories: categories,
                };
            }
            case DELETE_PRODUCT_SUCCESS: {
                const {id} = action.payload;
                const products = state.products.filter(product => product.id !== id);
                return {
                    ...state,
                    products: products,
                };
            }
            case DELETE_PRODUCT_SELECTION_SUCCESS: {
                const {id} = action.payload;
                const products = state.productSelection.filter(product => product.id !== id);
                return {
                    ...state,
                    productSelection: products,
                };
            }
            case 'DELETE_CATEGORY_SUCCESS': {
                const {id} = action.payload;
                const categories = state.categories.filter(category => category.id !== id);
                return {
                    ...state,
                    categories: categories,
                };
            }
            case CLEAR_ALL_PRODUCT: {
                return {
                    ...state,
                    products: [],
                };
            }
            case 'AUTH_SUCCESS': {
                return {
                    ...state,
                    isAuthenticated: true,
                    token: action.payload.accessToken,
                    username: action.payload.username,
                    avatar: action.payload.avatar,
                };
            }
            default: {
                return state;
            }
        }
    }, initialState);

    return <Provider value={{state, dispatch}}>{children}</Provider>;
};

export {StateProvider, initialState};
export default store;

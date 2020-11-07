import React, {createContext, useReducer} from 'react';

const GET_LIST_SUCCESS = 'GET_LIST_SUCCESS';
const EDIT_PRODUCT = 'EDIT_PRODUCT';
const EDIT_CATEGORY = 'EDIT_CATEGORY';
const UPDATE_PRODUCTS = 'UPDATE_PRODUCTS';
const UPDATE_CATEGORIES = 'UPDATE_CATEGORIES';
const DELETE_PRODUCT_SUCCESS = 'DELETE_PRODUCT_SUCCESS';
const CLEAR_ALL_PRODUCT = 'CLEAR_ALL_PRODUCTS';

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

export const authSuccess = (authValues) => ({
    type: 'AUTH_SUCCESS',
    payload: authValues,
});

export const authError = () => ({
    type: 'AUTH_ERROR',
    payload: {},
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
    products: [],
    categories: [],
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
                products.sort((p1, p2) => {
                    return p1.name.toLowerCase() > p2.name.toLowerCase() ? 1 : -1;
                });
                return {
                    ...state,
                    product: initialState.product,
                    products: products,
                };
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

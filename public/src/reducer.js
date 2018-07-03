import {combineReducers} from 'redux';
import "isomorphic-fetch";

export const apiBase = "api.php";

const initAuth = {
    username: localStorage.getItem('jmlshopping.username')
};

const clearStorage = () => {
    localStorage.removeItem('jmlshopping.username');
    localStorage.removeItem('jmlshopping.token');
};

const authReducer = (state = initAuth, action) => {
    switch (action.type) {
        case 'LOGIN_RESPONSE':
            if (action.status < 300) {
                localStorage.setItem('jmlshopping.username', action.data.username);
                localStorage.setItem('jmlshopping.token', action.data.token);
                return Object.assign({}, state, {username: action.data.username});
            }
            clearStorage();
            return state;
        case 'LOGOUT':
            clearStorage();
            return Object.assign({}, state, {username: null});
        default:
            return state;
    }
};

const initProducts = {
    product: {
        id: null,
        name: '',
        quantity: 0
    },
    products: []
};

const productsReducer = (state = initProducts, action) => {
    switch (action.type) {
        case 'PRODUCT_LIST_RESPONSE':
            return Object.assign({}, state, {products: action.data.products});
        case 'PRODUCT_EDIT':
            return Object.assign({}, state, {product: action.data.product});
        case 'PRODUCT_DELETE':
            if (confirm('Delete product ' + action.data.name + '?')) {
                fetch(apiBase + "/product/" + action.data.id, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-AUTH-TOKEN': localStorage.getItem('jmlshopping.token')
                    },
                    method: "DELETE"
                });
                return Object.assign({}, state, {products: state.products.filter(item => item.id !== action.data.id)});
            }
            return state;
        case 'PRODUCT_CLEAR_ALL':
            if (confirm('Delete all prooducts?')) {
                fetch(apiBase + "/products", {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-AUTH-TOKEN': localStorage.getItem('jmlshopping.token')
                    },
                    method: "DELETE"
                });
                return Object.assign({}, state, {products: []});
            }
            return state;
        default:
            return state;
    }
};

const initCategories = {
    category: {
        id: null,
        name: ''
    },
    categories: []
};

const categoryReducer = (state = initCategories, action) => {
    switch (action.type) {
        case 'CATEGORY_LIST_RESPONSE':
            return Object.assign({}, state, {categories: action.data.categories});
        default:
            return state;
    }
};

export default combineReducers({
    auth: authReducer,
    products: productsReducer,
    categories: categoryReducer
})
import {combineReducers} from 'redux';
import "isomorphic-fetch";

const initAuth = {
    username: localStorage.getItem('jmlshopping.username')
};

const authReducer = (state = initAuth, action) => {
    switch (action.type) {
        case 'LOGIN_RESPONSE':
            localStorage.setItem('jmlshopping.username', action.data.username);
            localStorage.setItem('jmlshopping.token', action.data.token);
            return Object.assign({}, state, {username: action.data.username});
        case 'LOGOUT':
            localStorage.removeItem('jmlshopping.username');
            localStorage.removeItem('jmlshopping.token');
            return Object.assign({}, state, {username: null});
        default:
            return state;
    }
};

const initProducts = {
    product: {},
    products: []
};

const productsReducer = (state = initProducts, action) => {
    switch (action.type) {
        case 'PRODUCT_LIST_RESPONSE':
            return Object.assign({}, state, {products: action.data.products});
        case 'PRODUCT_ADD':
            fetch("api_dev.php/product",
                {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: "POST",
                    body: JSON.stringify(action.data)
                });
            return state;
        case 'PRODUCT_DELETE':
            if (confirm('Delete product?')) {
                fetch("api_dev.php/product/" + action.id, {method: "DELETE"});
                return Object.assign({}, state, {products: state.products.filter(item => item.id !== action.id)});
            }
            return state;
        default:
            return state;
    }
};

export default combineReducers({
    auth: authReducer,
    products: productsReducer
})

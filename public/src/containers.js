import {connect} from 'react-redux';
import NavbarComponent from './components/Navbar';
import ProductTableComponent from './components/ProductTable';
import FooterComponent from './components/Footer';
import {login, logout, listProducts, addProduct, editProduct, deleteProduct, clearAll} from './actions';

export const ProductTable = connect(
    (state) => ({
        username: state.auth.username,
        product: state.products.product,
        products: state.products.products,
        categories: state.categories.categories
    }),
    (dispatch) => ({
        listProducts: () => dispatch(listProducts()),
        editProduct: (product) => dispatch(editProduct(product)),
        addProduct: (text, category, quantity) => dispatch(addProduct(text, category, quantity)),
        deleteProduct: id => dispatch(deleteProduct(id))
    })
)(ProductTableComponent);

export const Navbar = connect(
    (state) => ({username: state.auth.username}),
    (dispatch) => ({
        login: (username, password) => dispatch(login(username, password)),
        logout: () => dispatch(logout())
    })
)(NavbarComponent);

export const Footer = connect(
    (state) => ({username: state.auth.username}),
    (dispatch) => ({
        clearAll: () => dispatch(clearAll()),
    })
)(FooterComponent);

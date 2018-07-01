import {connect} from 'react-redux';
import NavbarComponent from './components/Navbar';
import ProductTableComponent from './components/ProductTable';
import CategoriesTableComponent from './components/CategoryTable';
import FooterComponent from './components/Footer';
import * as actions from './actions';

export const ProductTable = connect(
    (state) => ({
        username: state.auth.username,
        product: state.products.product,
        products: state.products.products,
        categories: state.categories.categories
    }),
    (dispatch) => ({
        listProducts: () => dispatch(actions.listProducts()),
        editProduct: (product) => dispatch(actions.editProduct(product)),
        addProduct: (text, category, quantity) => dispatch(actions.addProduct(text, category, quantity)),
        deleteProduct: id => dispatch(actions.deleteProduct(id))
    })
)(ProductTableComponent);

export const CategoriesTable = connect(
    (state) => ({
        username: state.auth.username,
        categories: state.categories.categories
    }),
    (dispatch) => ({
        listCategories: () => dispatch(actions.listCategories()),
        // editProduct: (product) => dispatch(actions.editProduct(product)),
        // addProduct: (text, category, quantity) => dispatch(actions.addProduct(text, category, quantity)),
        // deleteProduct: id => dispatch(actions.deleteProduct(id))
    })
)(CategoriesTableComponent);

export const Navbar = connect(
    (state) => ({username: state.auth.username}),
    (dispatch) => ({
        login: (username, password) => dispatch(actions.login(username, password)),
        logout: () => dispatch(actions.logout())
    })
)(NavbarComponent);

export const Footer = connect(
    (state) => ({username: state.auth.username}),
    (dispatch) => ({
        clearAll: () => dispatch(actions.clearAll()),
    })
)(FooterComponent);

import {connect} from 'react-redux';
import * as components from './components/ProductTable';
import {addProduct, deleteProduct} from './actions';

export const ProductTable = connect(
    function mapStateToProps(state) {
        return {products: state};
    },
    function mapDispatchToProps(dispatch) {
        return {
            addProduct: (text, category, quantity) => dispatch(addProduct(text, category, quantity)),
            deleteProduct: id => dispatch(deleteProduct(id))
        };
    }
)(components.ProductTable);

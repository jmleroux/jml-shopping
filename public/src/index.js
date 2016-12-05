import React from 'react';
import {render} from 'react-dom';
import {createStore} from 'redux';
import {Provider} from 'react-redux';
import reducer from './reducer';
import {ProductTable} from './containers';

const store = createStore(reducer);

someAsyncCall().then(function(response) {
    store.dispatch(someActionCreator(response));
});
fetch("api_dev.php/products")
    .then(response => response.json())
    .then(json => {
        store.dispatch(someActionCreator(response));
    });

render(
    <Provider store={store}>
        <ProductTable />
    </Provider>,
    document.getElementById("product-list")
);

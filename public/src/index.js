import React from 'react';
import {render} from 'react-dom';

import thunkMiddleware from 'redux-thunk'
import createLogger from 'redux-logger'
import {createStore, applyMiddleware} from 'redux'
import {Provider} from 'react-redux';

import reducer from './reducer';
import {ProductTable, Navbar, Footer} from './containers';

const loggerMiddleware = createLogger();

const store = createStore(
    reducer,
    applyMiddleware(
        loggerMiddleware,
        thunkMiddleware
    )
);

render(
    <Provider store={store}>
        <Navbar />
    </Provider>,
    document.getElementById("login-container")
);

render(
    <Provider store={store}>
        <ProductTable />
    </Provider>,
    document.getElementById("product-list")
);

render(
    <Provider store={store}>
        <Footer />
    </Provider>,
    document.getElementById("footer")
);

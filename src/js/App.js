import React from 'react';
import {HashRouter, Route, Switch} from 'react-router-dom';
import {StateProvider} from './store';

import ProductForm from "./components/ProductForm";
import ProductTable from "./components/ProductTable";
import CategoryForm from "./components/CategoryForm";
import CategoryTable from "./components/CategoryTable";
import Menu from "./components/Menu";

const App = () => {
    return (
        <StateProvider>
            <HashRouter>
                <Menu/>
                <div>
                    <Switch>
                        <Route path="/product-list">
                            <ProductForm/>
                            <ProductTable />
                        </Route>
                        <Route path="/category-list">
                            <CategoryForm/>
                            <CategoryTable />
                        </Route>
                        <Route>
                            <ProductForm/>
                            <ProductTable />
                        </Route>
                    </Switch>
                </div>

            </HashRouter>
        </StateProvider>
    );
};

export default App;

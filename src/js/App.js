import React from 'react';
import {HashRouter, Switch} from 'react-router-dom';
import {StateProvider} from './store';
import Menu from "./components/Menu";
import CategoryPage from "./CategoryPage";
import PrivateRoute from "./PrivateRoute";
import ProductPage from "./ProductPage";
import ProductSelectionPage from "./ProductSelectionPage";

const App = () => {
    return (
        <StateProvider>
            <HashRouter>
                <Menu/>
                <div>
                    <Switch>
                        <PrivateRoute path="/category-list" component={CategoryPage}/>
                        <PrivateRoute path="/product-selection" component={ProductSelectionPage}/>
                        <PrivateRoute path="/" component={ProductPage}/>
                    </Switch>
                </div>

            </HashRouter>
        </StateProvider>
    );
};

export default App;

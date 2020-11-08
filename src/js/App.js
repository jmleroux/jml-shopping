import React from 'react';
import {HashRouter, Route, Switch} from 'react-router-dom';
import {StateProvider} from './store';
import Menu from "./components/Menu";
import CategoryPage from "./CategoryPage";
import PrivateRoute from "./PrivateRoute";
import ProductPage from "./ProductPage";
import AnonymousPage from "./AnonymousPage";

const App = () => {
    return (
        <StateProvider>
            <HashRouter>
                <Menu/>
                <div>
                    <Switch>
                        <PrivateRoute path="/category-list" component={CategoryPage}/>
                        <PrivateRoute path="/" component={ProductPage}/>
                        <Route path="/" component={AnonymousPage}/>
                    </Switch>
                </div>

            </HashRouter>
        </StateProvider>
    );
};

export default App;

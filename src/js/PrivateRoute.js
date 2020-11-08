import React, {useContext, useLayoutEffect} from 'react';
import {Route} from 'react-router-dom';
import store from "./store";
import AnonymousPage from "./AnonymousPage";

function PrivateRoute({component: Component, ...rest}) {

    const {state} = useContext(store);

    useLayoutEffect(() => {
    }, [])

    return (
        <Route {...rest} render={(props) => {
            if (state.isAuthenticated) {
                return (
                    <Component {...props} />
                )
            }
            return (<AnonymousPage/>)
        }}
        />
    );
}

export default PrivateRoute;

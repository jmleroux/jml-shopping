import React, {useContext, useEffect, useLayoutEffect} from 'react';
import {Route} from 'react-router-dom';
import store, {authCheckToken} from "./store";

function PrivateRoute({component: Component, ...rest}) {

    const {state} = useContext(store);

    useLayoutEffect(() => {
    }, [])

    return (
        <Route {...rest} render={(props) => (
            state.isAuthenticated &&
            <Component {...props} />
        )}
        />
    );
}

export default PrivateRoute;

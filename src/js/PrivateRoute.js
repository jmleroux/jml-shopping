import React, {useContext, useEffect, useLayoutEffect} from 'react';
import {Route} from 'react-router-dom';
import store, {authCheckToken} from "./store";

function PrivateRoute({component: Component, ...rest}) {

    const {dispatch} = useContext(store);

    useLayoutEffect(() => {
    }, [])

    return (
        <Route {...rest} render={(props) => (
            <Component {...props} />
        )}
        />
    );
}

export default PrivateRoute;

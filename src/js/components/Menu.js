import React, {Fragment, useContext} from "react";
import {Link} from 'react-router-dom';
import store from "../store";
import Login from "./Login";

export default () => {
    const {state} = useContext(store);

    return (
        <div className="ui menu">
            {state.isAuthenticated &&
            <Fragment>
                <Link className="item" to="/product-list">Products</Link>
                <Link className="item" to="/category-list">Categories</Link>
            </Fragment>
            }
            <div className="right menu">
                {state.isAuthenticated ?
                    <Fragment>
                        <a className="item">
                            <img className="avatar" src={state.avatar} title={state.username}/>
                        </a>
                    </Fragment>
                    :
                    <Fragment>
                        <Login/>
                    </Fragment>
                }
            </div>
        </div>
    )
}

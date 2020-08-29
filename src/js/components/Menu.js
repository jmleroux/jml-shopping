import React from "react";
import {Link} from 'react-router-dom';

export default () => {
    return (
        <div className="ui menu">
            <Link className="item" to="/product-list">Products</Link>
            <Link className="item" to="/category-list">Categories</Link>
            <div className="right menu">
                <a className="item" href="#">username</a>
                <a className="item" href="#">Logout</a>
            </div>
        </div>
    )
}

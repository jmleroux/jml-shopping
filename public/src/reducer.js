import {List, Map} from 'immutable';
import "isomorphic-fetch";

const init = [];

export default function (products = init, action) {
    switch (action.type) {
        case 'PRODUCT_ADD':
            fetch("api_dev.php/product",
                {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: "POST",
                    body: JSON.stringify(action.data)
                });
            return [...products, action.data];
        case 'PRODUCT_DELETE':
            fetch("api_dev.php/product/" + action.id, {method: "DELETE"});
            return products.filter(item => item.id !== action.id);
        default:
            return products;
    }
}

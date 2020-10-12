import axios from 'axios';

const addAuthTokenHeader = (state, config = {}) => {
    if (state.token) {
        config = {
            ...config,
            headers: {
                'X-AUTH-TOKEN': state.token
            }
        };
    }

    return config;
}

export default {
    getProducts: (state) => {
        const config = addAuthTokenHeader(state);
        return axios.get('/api/products', config);
    },
    createProduct: (state, productData) => {
        const config = addAuthTokenHeader(state);
        const payload = JSON.stringify(productData);
        return axios.post('/api/product', payload, config);
    },
    deleteProduct: (state, id) => {
        const config = addAuthTokenHeader(state);
        return axios.delete(`api/product/${id}`, config);
    },
    deleteProducts: (state) => {
        const config = addAuthTokenHeader(state);
        return axios.delete(`api/products`, config);
    },
}

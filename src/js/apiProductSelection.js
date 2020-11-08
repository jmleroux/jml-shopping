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
    getProductSelection: (state) => {
        const config = addAuthTokenHeader(state);
        return axios.get('/api/product-selection', config);
    },
    createProductSelection: (state, productData) => {
        const config = addAuthTokenHeader(state);
        const payload = JSON.stringify(productData);
        return axios.post('/api/product-selection', payload, config);
    },
    deleteProductSelection: (state, id) => {
        const config = addAuthTokenHeader(state);
        return axios.delete(`api/product-selection/${id}`, config);
    },
}

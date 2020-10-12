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
    getCategories: (state) => {
        const config = addAuthTokenHeader(state);
        return axios.get('/api/categories', config);
    },
    createCategory: (state, categoryData) => {
        const config = addAuthTokenHeader(state);
        const payload = JSON.stringify(categoryData);
        return axios.post('/api/category', payload, config);
    },
    deleteCategory: (state, id) => {
        const config = addAuthTokenHeader(state);
        return axios.delete(`api/category/${id}`, config);
    },
}

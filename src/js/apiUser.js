import axios from 'axios';

export default {
    isAuthorized: (token) => {
        const config = {
            headers: {'X-AUTH-TOKEN': token}
        };
        return axios.get('/api/check_token', config);
    },
}

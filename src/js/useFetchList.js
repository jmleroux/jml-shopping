import {useContext, useEffect} from 'react';
import store, {authError, getListSuccess} from './store';
import axios from 'axios';

const useFetchList = ({resource}) => {
    const {state, dispatch} = useContext(store);

    useEffect(() => {
        const fetchData = async () => {
            const url = `api/${resource}`;
            let config = {
                headers: {}
            };
            if (state.token) {
                config.headers['X-AUTH-TOKEN'] = state.token;
            }
            try {
                const response = await axios.get(url, config);
                dispatch(getListSuccess(response.data, resource));
            } catch (error) {
                if (403 === error.response.status) {
                    dispatch(authError())
                }
            }
        };
        fetchData();
    }, [resource, dispatch]);
};

export default useFetchList;

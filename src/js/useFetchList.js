import {useContext, useEffect} from 'react';
import store from './store';
import axios from 'axios';

import {getListSuccess} from './store';

const useFetchList = ({resource}) => {
    const {state, dispatch} = useContext(store);

    useEffect(() => {
        const fetchData = async () => {
            const url = `api/${resource}`;
            const response = await axios.get(url);
            dispatch(getListSuccess(response.data, resource));
        };
        fetchData();
    }, [resource, dispatch]);
};

export default useFetchList;

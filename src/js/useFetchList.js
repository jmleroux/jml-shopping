import {useContext, useEffect} from 'react';
import store, {authError, getListSuccess} from './store';
import apiProduct from "./apiProduct";
import apiCategory from "./apiCategory";

const useFetchList = ({resource}) => {
    const {state, dispatch} = useContext(store);

    useEffect(() => {
        const fetchData = async () => {
            let api = null;
            if ('products' === resource) {
                api = apiProduct.getProducts;
            }
            if ('categories' === resource) {
                api = apiCategory.getCategories;
            }
            if (null !== api) {
                try {
                    const response = await api(state);
                    dispatch(getListSuccess(response.data, resource));
                } catch (error) {
                    if (403 === error.response.status) {
                        dispatch(authError())
                    }
                }
            }
        };
        fetchData();
    }, [resource, dispatch]);
};

export default useFetchList;

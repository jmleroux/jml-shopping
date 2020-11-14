import {useContext, useEffect} from 'react';
import store, {getListSuccess} from './store';
import apiProduct from "./apiProduct";
import apiCategory from "./apiCategory";
import apiProductSelection from "./apiProductSelection";

const useFetchList = ({resource}) => {
    const {state, dispatch} = useContext(store);

    useEffect(() => {
        const fetchData = async () => {
            let api = null;
            if ('products' === resource) {
                api = apiProduct.getProducts;
            }
            if ('productSelection' === resource) {
                api = apiProductSelection.getProductSelection;
            }
            if ('categories' === resource) {
                api = apiCategory.getCategories;
            }
            if (null !== api) {
                console.info('Fetching resource ' + resource);
                const response = await api(state);
                dispatch(getListSuccess(response.data, resource));
            }
        };
        fetchData();
    }, [dispatch]);
};

export default useFetchList;

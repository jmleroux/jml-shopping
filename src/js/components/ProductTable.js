import React, {Fragment, useContext, useEffect, useState} from "react";
import {Button, Confirm, Icon, Table} from 'semantic-ui-react'

import store, {clearAllProducts, deleteProductSuccess, editProduct, getListSuccess} from "../store";
import apiProduct from "../apiProduct";
import apiCategory from "../apiCategory";
import {categoryName, sortProducts} from "../utils";

const ProductRow = ({product}) => {

    const {state, dispatch} = useContext(store);
    const [confirmDelete, setConfirmDelete] = useState(false);

    const handleEdit = async (product) => {
        dispatch(editProduct(product));
    };

    const handleDelete = async (id) => {
        await apiProduct.deleteProduct(state, id);
        dispatch(deleteProductSuccess(id));
    };

    return (
        <tr>
            <td className="product-name">{product.name}</td>
            <td className="product-category">{categoryName(state, product.category_id)}</td>
            <td className="product-quantity">{product.quantity}</td>
            <td className="product-quantity">
                <Button size="mini" icon="edit" onClick={() => handleEdit(product)}/>
                <Button size="mini" icon="trash" onClick={() => setConfirmDelete(true)}/>
            </td>
            <Confirm
                open={confirmDelete}
                content={"You will delete this product"}
                header={product.name + ': Warning!'}
                cancelButton='Nope'
                confirmButton="Let's do it"
                onCancel={() => setConfirmDelete(false)}
                onConfirm={() => handleDelete(product.id)}
                size='mini'
            />
        </tr>
    );
};

const ProductTable = () => {

    const {state, dispatch} = useContext(store);
    const [confirmClear, setConfirmClear] = useState(false);
    const [loadedCategories, setLoadedCategories] = useState(false);

    useEffect(() => {
        const fetchData = async () => {
            console.info('Fetch categories');
            const response = await apiCategory.getCategories(state);
            dispatch(getListSuccess(response.data, 'categories'));
            setLoadedCategories(true);
        };
        fetchData();
    }, [dispatch]);

    useEffect(() => {
        if (loadedCategories) {
            const fetchData = async () => {
                console.info('Fetch products');
                const response = await apiProduct.getProducts(state);
                dispatch(getListSuccess(response.data, 'products'));
            };
            fetchData();
        }
    }, [loadedCategories, dispatch]);

    const handleClearAll = () => {
        apiProduct.deleteProducts(state);
        dispatch(clearAllProducts());
        setConfirmClear(false);
    };

    return (
        <Fragment>
            <Table compact unstackable>
                <thead>
                <tr>
                    <Table.HeaderCell className="product-name" width={5}>Name</Table.HeaderCell>
                    <Table.HeaderCell className="product-category" width={5}>Category</Table.HeaderCell>
                    <Table.HeaderCell className="product-quantity" width={2}>Quantity</Table.HeaderCell>
                    <Table.HeaderCell width={1}>Operations</Table.HeaderCell>
                </tr>
                </thead>
                <tbody>
                {sortProducts(state, state.products).map(product => (
                    <ProductRow key={product.id} product={product}/>
                ))}
                </tbody>
            </Table>
            <Button icon labelPosition='left' onClick={() => setConfirmClear(true)}>
                <Icon name='trash alternate'/> Clear All
            </Button>
            <Confirm
                open={confirmClear}
                content='You will clear all products'
                header='Warning!'
                cancelButton='Nope'
                confirmButton="Let's do it"
                onCancel={() => setConfirmClear(false)}
                onConfirm={handleClearAll}
                size='mini'
            />
        </Fragment>
    );
};

export default ProductTable;

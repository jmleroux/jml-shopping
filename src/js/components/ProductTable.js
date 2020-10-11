import React, {useContext, useState} from "react";
import axios from 'axios';
import {Button, Confirm, Container, Icon, Table} from 'semantic-ui-react'

import store, {clearAllProducts, deleteProductSuccess, editProduct} from "../store";
import useFetchList from "../useFetchList";

const ProductRow = ({product}) => {

    const {state, dispatch} = useContext(store);
    const [confirmDelete, setConfirmDelete] = useState(false);

    const handleEdit = async (product) => {
        dispatch(editProduct(product));
    };

    const handleDelete = async (id) => {
        let config = {}
        if (state.token) {
            config = {...config, headers: {'X-AUTH-TOKEN': state.token}};
        }
        await axios.delete(`api/product/${id}`, config);
        dispatch(deleteProductSuccess(id));
    };

    return (
        <tr>
            <td className="product-name">{product.name}</td>
            <td className="product-category">{product.category}</td>
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
                size='tiny'
            />
        </tr>
    );
};

const ProductTable = () => {

    const {state, dispatch} = useContext(store);
    const [confirmClear, setConfirmClear] = useState(false);

    useFetchList({
        resource: 'products',
    });

    useFetchList({
        resource: 'categories',
    });

    const handleClearAll = () => {
        axios.delete(`api/products`);
        dispatch(clearAllProducts());
        setConfirmClear(false);
    };

    return (
        <Container>
            <Table compact unstackable>
                <thead>
                <tr>
                    <th className="product-name">Name</th>
                    <th className="product-category">Category</th>
                    <th className="product-quantity">Quantity</th>
                    <Table.HeaderCell width={1}>Operations</Table.HeaderCell>
                </tr>
                </thead>
                <tbody>
                {state.products.map(product => (
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
                size='tiny'
            />
        </Container>
    );
};

export default ProductTable;

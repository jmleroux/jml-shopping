import React, {Fragment, useContext, useState} from "react";
import {Button, Checkbox, Confirm, Icon, Table} from 'semantic-ui-react'

import store, {addSelectionToList, deleteProductSelectionSuccess} from "../store";
import useFetchList from "../useFetchList";
import apiProductSelection from "../apiProductSelection";
import {categoryName, sortProducts} from "../utils";

const ProductRow = ({product, handleCheckedProduct}) => {

    const {state, dispatch} = useContext(store);
    const [confirmDelete, setConfirmDelete] = useState(false);

    const handleDelete = async (id) => {
        await apiProductSelection.deleteProductSelection(state, id);
        dispatch(deleteProductSelectionSuccess(id));
    };

    const handleCheck = (event, data) => {
        const id = data.value
        const checked = data.checked
        handleCheckedProduct(id, checked)
    };

    return (
        <tr>
            <td className="product-selection-checkbox">
                <Checkbox
                    value={product.id}
                    onChange={handleCheck}
                />
            </td>
            <td className="product-name">{product.name}</td>
            <td className="product-category">{categoryName(state, product.category_id)}</td>
            <td className="product-operation">
                <Button size="mini" icon="trash" onClick={() => setConfirmDelete(true)}/>
            </td>
            <Confirm
                open={confirmDelete}
                content={"You will delete this product selection"}
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

const ProductSelectionTable = () => {

    const {state, dispatch} = useContext(store);
    const [confirmClear, setConfirmClear] = useState(false);
    const [checkedProducts, setCheckedProducts] = useState([]);

    useFetchList({
        resource: 'categories',
    });

    useFetchList({
        resource: 'productSelection',
    });

    const handleCheckedProduct = (id, checked) => {
        let list = checkedProducts;
        if (checked) {
            list.push(id);
        } else {
            list = list.filter(item => item !== id)
        }
        setCheckedProducts(list);
    };

    const handleAddToList = () => {
        dispatch(addSelectionToList(checkedProducts));
        setConfirmClear(false);
    };

    return (
        <Fragment>
            <Table compact unstackable>
                <thead>
                <tr>
                    <Table.HeaderCell className="product-name" width={1}/>
                    <Table.HeaderCell className="product-name" width={5}>Name</Table.HeaderCell>
                    <Table.HeaderCell className="product-category" width={5}>Category</Table.HeaderCell>
                    <Table.HeaderCell width={1}>Operations</Table.HeaderCell>
                </tr>
                </thead>
                <tbody>
                {sortProducts(state, state.productSelection).map(product => (
                    <ProductRow key={product.id} product={product} handleCheckedProduct={handleCheckedProduct}/>
                ))}
                </tbody>
            </Table>
            <Button icon labelPosition='left' onClick={() => setConfirmClear(true)}>
                <Icon name='shopping cart'/> Add to list
            </Button>
            <Confirm
                open={confirmClear}
                content='You will add these products to your list'
                header='Warning!'
                cancelButton='Nope'
                confirmButton="Let's do it"
                onCancel={() => setConfirmClear(false)}
                onConfirm={handleAddToList}
                size='tiny'
            />
        </Fragment>
    );
};

export default ProductSelectionTable;

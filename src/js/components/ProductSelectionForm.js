import React, {useContext} from "react";
import {Button, Container, Dropdown, Form, Input} from 'semantic-ui-react'

import store, {editProduct, editProductSelection, updateProducts, updateProductSelection} from "../store";
import apiProduct from "../apiProduct";
import apiProductSelection from "../apiProductSelection";

const ProductSelectionForm = () => {

    const {state, dispatch} = useContext(store);
    const currentProductSelection = state.currentProductSelection;
    const categories = state.categories;

    const handleSubmit = async (event) => {
        if (event) event.preventDefault();
        const result = await apiProductSelection.createProductSelection(state, currentProductSelection);
        const newProduct = result.data;
        dispatch(editProductSelection(newProduct));
        dispatch(updateProductSelection());
    };

    const handleChange = (event) => {
        dispatch(editProductSelection({
            ...currentProductSelection,
            [event.target.name]: event.target.value
        }));
    };

    const handleChangeCategory = (event, {value}) => {
        dispatch(editProductSelection({
            ...currentProductSelection,
            category_id: value,
            category: event.currentTarget.textContent,
        }));
    };

    const categoryOptions = categories.map(categoryItem => {
        return {
            key: categoryItem.id,
            text: categoryItem.name,
            value: categoryItem.id,
        }
    });

    return (
        <Container>
            <Form onSubmit={handleSubmit}>
                <div className='inline fields'>
                    <Form.Field>
                        <Input type='text' name='name' value={currentProductSelection.name} onChange={handleChange}/>
                    </Form.Field>
                    <Form.Field>
                        <Dropdown selection onChange={handleChangeCategory}
                                  options={categoryOptions}
                                  value={currentProductSelection.category_id}/>
                    </Form.Field>
                    <Form.Field>
                        <Button icon="save" type="submit"/>
                    </Form.Field>
                </div>
            </Form>
        </Container>
    );
};

export default ProductSelectionForm;

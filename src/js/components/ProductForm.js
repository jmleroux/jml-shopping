import React, {useContext} from "react";
import {Button, Container, Dropdown, Form, Input} from 'semantic-ui-react'

import store, {editProduct, updateProducts} from "../store";
import apiProduct from "../apiProduct";

const ProductForm = () => {

    const {state, dispatch} = useContext(store);
    const product = state.product;
    const categories = state.categories;

    const handleSubmit = async (event) => {
        if (event) event.preventDefault();
        const result = await apiProduct.createProduct(state, product);
        dispatch(updateProducts());
    };

    const handleChange = (event) => {
        dispatch(editProduct({
            ...product,
            [event.target.name]: event.target.value
        }));
    };

    const handleChangeCategory = (event, {value}) => {
        dispatch(editProduct({
            ...product,
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
                <Form.Group unstackable>
                    <Form.Field>
                        <Input type='text' name='name' value={product.name} onChange={handleChange}/>
                    </Form.Field>
                    <Form.Field>
                        <Dropdown selection onChange={handleChangeCategory}
                                  options={categoryOptions}
                                  value={product.category_id}/>
                    </Form.Field>
                    <Form.Field>
                        <Input type="number" name='quantity' value={product.quantity} onChange={handleChange}/>
                    </Form.Field>
                    <Form.Field>
                        <Button icon="save" type="submit"/>
                    </Form.Field>
                </Form.Group>
            </Form>
        </Container>
    );
};

export default ProductForm;

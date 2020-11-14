import React, {useContext, useRef} from "react";
import {Button, Container, Dropdown, Form, Input} from 'semantic-ui-react'

import store, {editProduct, updateProducts} from "../store";
import apiProduct from "../apiProduct";

const useFocus = () => {
    const htmlElRef = useRef(null)
    const setFocus = () => {
        htmlElRef.current && htmlElRef.current.focus()
    }

    return [htmlElRef, setFocus]
}

const ProductForm = () => {

    const {state, dispatch} = useContext(store);
    const product = state.product;
    const categories = state.categories;
    const [inputRef, setInputFocus] = useFocus();

    const handleSubmit = async (event) => {
        if (event) event.preventDefault();
        const result = await apiProduct.createProduct(state, product);
        const newProduct = result.data;
        dispatch(editProduct(newProduct));
        dispatch(updateProducts());
        setInputFocus();
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
                <div className='inline fields'>
                    <Form.Field>
                        <Input type='text' name='name' autoFocus value={product.name} onChange={handleChange}
                               ref={inputRef}/>
                    </Form.Field>
                    <Form.Field>
                        <Dropdown selection onChange={handleChangeCategory}
                                  search
                                  options={categoryOptions}
                                  value={product.category_id}/>
                    </Form.Field>
                    <Form.Field>
                        <Input type="number" name='quantity'
                               value={product.quantity} onChange={handleChange}/>
                    </Form.Field>
                    <Form.Field>
                        <Button icon="save" type="submit"/>
                    </Form.Field>
                </div>
            </Form>
        </Container>
    );
};

export default ProductForm;

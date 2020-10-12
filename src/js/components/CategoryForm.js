import React, {useContext} from "react";
import {Button, Container, Form, Input} from 'semantic-ui-react'

import store, {editCategory, updateCategories} from '../store';
import apiCategory from "../apiCategory";

const CategoryForm = () => {

    const {state, dispatch} = useContext(store);
    const category = state.category;

    const handleSubmit = async (event) => {
        if (event) event.preventDefault();
        await apiCategory.createCategory(state, category);
        dispatch(updateCategories());
    };

    const handleChange = (event) => {
        dispatch(editCategory({
            ...category,
            name: event.target.value
        }));
    };

    return (
        <Container>
            <Form onSubmit={handleSubmit}>
                <Form.Group inline>
                    <Form.Field>
                        <Input type='text' name='name' value={category.name} onChange={handleChange}/>
                    </Form.Field>
                    <Form.Field>
                        <Button icon="save" type="submit"/>
                    </Form.Field>
                </Form.Group>
            </Form>
        </Container>
    );
};

export default CategoryForm;

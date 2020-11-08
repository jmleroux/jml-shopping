import React from 'react';
import CategoryForm from "./components/CategoryForm";
import CategoryTable from "./components/CategoryTable";
import {Container} from "semantic-ui-react";

export default () => (
    <Container>
        <h2>Categories</h2>
        <CategoryForm/>
        <CategoryTable/>
    </Container>
);

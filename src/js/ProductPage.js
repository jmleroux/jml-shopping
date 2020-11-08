import React from 'react';
import ProductForm from "./components/ProductForm";
import ProductTable from "./components/ProductTable";
import {Container} from "semantic-ui-react";

export default () => (
    <Container>
        <h2>Product list</h2>
        <ProductForm/>
        <ProductTable/>
    </Container>
);

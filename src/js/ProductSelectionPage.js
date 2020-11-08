import React from 'react';
import {Container} from "semantic-ui-react";
import ProductSelectionForm from "./components/ProductSelectionForm";
import ProductSelectionTable from "./components/ProductSelectionTable";

export default () => (
    <Container>
        <h2>Product selection</h2>
        <ProductSelectionForm/>
        <ProductSelectionTable/>
    </Container>
);

import React, {useContext, useState} from "react";
import {Button, Confirm, Container, Table} from 'semantic-ui-react'

import useFetchList from "../useFetchList";
import store, {deleteCategorySuccess, editCategory} from "../store";
import axios from "axios";

const CategoryRow = ({category}) => {

    const {dispatch} = useContext(store);
    const [confirmDelete, setConfirmDelete] = useState(false);

    const handleEdit = (category) => {
        dispatch(editCategory(category));
    };

    const handleDelete = async (id) => {
        await axios.delete(`api/category/${id}`);
        dispatch(deleteCategorySuccess(id));
    };

    return (
        <tr>
            <td className="category-name">{category.name}</td>
            <td>
                <Button size="mini" icon="edit" onClick={() => {
                    handleEdit(category)
                }}/>
                <Button size="mini" icon="trash" onClick={() => setConfirmDelete(true)}/>
            </td>
            <Confirm
                open={confirmDelete}
                content={"You will delete this category"}
                header={category.name + ': Warning!'}
                cancelButton='Nope'
                confirmButton="Let's do it"
                onCancel={() => setConfirmDelete(false)}
                onConfirm={() => handleDelete(category.id)}
                size='tiny'
            />
        </tr>
    );
}

const CategoryTable = () => {

    const {state} = useContext(store);

    useFetchList({
        resource: 'categories',
    });

    return (
        <Container>
            <Table compact unstackable>
                <thead>
                <tr>
                    <th>Name</th>
                    <Table.HeaderCell width={1}>Operations</Table.HeaderCell>
                </tr>
                </thead>
                <tbody>
                {state.categories.map(category => (
                    <CategoryRow key={category.id} category={category}/>
                ))}
                </tbody>
            </Table>
        </Container>
    );
};

export default CategoryTable;

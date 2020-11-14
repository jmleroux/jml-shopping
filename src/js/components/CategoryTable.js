import React, {Fragment, useContext, useState} from "react";
import {Button, Confirm, Table} from 'semantic-ui-react'

import useFetchList from "../useFetchList";
import store, {deleteCategorySuccess, editCategory} from "../store";
import apiCategory from "../apiCategory";

const CategoryRow = ({category}) => {

    const {state, dispatch} = useContext(store);
    const [confirmDelete, setConfirmDelete] = useState(false);

    const handleEdit = (category) => {
        dispatch(editCategory(category));
    };

    const handleDelete = async (id) => {
        await apiCategory.deleteCategory(state, id);
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
                size='mini'
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
        <Fragment>
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
        </Fragment>
    );
};

export default CategoryTable;

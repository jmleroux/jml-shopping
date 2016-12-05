export function ProductRow(props) {
    const {product, deleteAction} = props;

    const onClick = (productId) => {
        deleteAction(productId);
    };

    return (
        <tr>
            <td>{product.name}</td>
            <td>{product.category}</td>
            <td>{product.quantity}</td>
            <td>
                <button type="button" className="btn btn-default btn-xs">
                    <span className="glyphicon glyphicon-edit"/>
                </button>
            </td>
            <td>
                <button type="button" className="btn btn-default btn-xs" onClick={() => onClick(product.id)}>
                    <span className="glyphicon glyphicon-trash"/>
                </button>
            </td>
        </tr>
    );
}

export function ProductTable(props) {
    const {products, addProduct, deleteProduct} = props;

    const rows = [];

    const onSubmit = (event) => {
        const input = event.target;
        const text = input.value;
        const isEnterKey = (event.which == 13);
        const isLongEnough = text.length > 0;

        if (isEnterKey && isLongEnough) {
            input.value = '';
            addProduct(text, 'fou', 'bar');
        }
    };

    products.forEach((product) => rows.push(<ProductRow key={product.id} product={product} deleteAction={deleteProduct} />));


    return (
        <table className="table table-condensed">
            <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input type='text'
                           className='todo__entry'
                           placeholder='Add todo'
                           onKeyDown={onSubmit}/>
                </td>
                <td/>
                <td><input type="number" name="product.quantity"/></td>
                <td>
                    <button type="submit" className="btn btn-default btn-sm">
                        <span className="glyphicon glyphicon-ok-circle"/>
                    </button>
                </td>
                <td/>
            </tr>
            {rows}
            </tbody>
        </table>
    );
}

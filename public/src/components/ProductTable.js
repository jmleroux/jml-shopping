import * as React from "react";

function ProductRow(props) {
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

export default class ProductTable extends React.Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        this.props.listProducts();
    }

    handleClick() {
        this.props.addProduct(this.props.product);
        this.props.listProducts();
    }

    handleChange(event) {
        const inputName = event.target.name;
        this.props.product[inputName] = event.target.value;
    }

    render() {
        const {username} = this.props;
        const rows = [];
        if (username) {
            return (
                <table className="table table-condensed">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th style={{width: '30px'}}/>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type='text'
                                   className='todo__entry'
                                   placeholder='Add todo'
                                   name='name'
                                   onChange={(event) => this.handleChange(event)}
                        /></td>
                        <td/>
                        <td><input type="number"
                                   name='quantity'
                                   onChange={(event) => this.handleChange(event)}/></td>
                        <td>
                            <button type="submit" className="btn btn-default btn-sm" onClick={() => this.handleClick()}>
                                <span className="glyphicon glyphicon-ok-circle"/>
                            </button>
                        </td>
                        <td/>
                    </tr>
                    {this.props.products.forEach(
                        (product) => {
                            rows.push(<ProductRow key={product.id}
                                                  product={product}
                                                  deleteAction={this.props.deleteProduct}/>);
                        }
                    )}
                    {rows}
                    </tbody>
                </table>
            );
        } else {
            return (<div>You must be authenticated</div>);
        }
    }
}

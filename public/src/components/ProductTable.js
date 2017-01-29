import * as React from "react";

class ProductRow extends React.Component {

    onEdit(product) {
        this.props.editAction(product);
    }

    onDelete(product) {
        this.props.deleteAction(product);
    }

    render() {
        const product = this.props.product;
        return (
            <tr>
                <td className="product-name">{product.name}</td>
                <td className="product-category">{product.category}</td>
                <td className="product-quantity">{product.quantity}</td>
                <td className="product-operations">
                    <button type="button" className="btn btn-default btn-xs" onClick={() => this.onEdit(product)}>
                        <span className="glyphicon glyphicon-edit"/>
                    </button>
                    <button type="button" className="btn btn-default btn-xs" onClick={() => this.onDelete(product)}>
                        <span className="glyphicon glyphicon-trash"/>
                    </button>
                </td>
            </tr>
        );
    }
}

class CategoryOption extends React.Component {
    render() {
        const {category} = this.props;
        return (<option key={category.id} value={category.id}>{category.name}</option>);
    }
}

export default class ProductTable extends React.Component {
    constructor(props) {
        super(props);
        this.state = {product: props.product};
    }

    componentDidMount() {
        const {username} = this.props;
        if (username) {
            this.props.listProducts();
        }
    }

    handleClick() {
        this.props.addProduct(this.state.product);
        this.props.listProducts();
        this.props.product.name = '';
    }

    handleChange(event) {
        const inputName = event.target.name;
        this.state.product[inputName] = event.target.value;
    }

    render() {
        const {username} = this.props;
        const categories = [];
        const rows = [];
        if (username) {
            return (
                <table className="table table-condensed">
                    <thead>
                    <tr>
                        <th className="product-name">Name</th>
                        <th className="product-category">Category</th>
                        <th className="product-quantity">Quantity</th>
                        <th className="product-operations"/>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type='text'
                                   className='form-control todo__entry'
                                   name='name'
                                   value={this.state.product.name}
                                   onChange={(event) => this.handleChange(event)}
                        /></td>
                        <td>
                            <select className="form-control"
                                    name="category_id"
                                    value={this.state.product.category_id}
                                    onChange={(event) => this.handleChange(event)}>
                                {categories.push(<CategoryOption key="0" category={[]}/>)}
                                {this.props.categories.forEach((category) => {
                                    categories.push(<CategoryOption key={category.id} category={category}/>)
                                })}
                                {categories}
                            </select>
                        </td>
                        <td><input type="number"
                                   className='form-control todo__quantity'
                                   name='quantity'
                                   value={this.state.product.quantity}
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
                                                  categories={this.props.categories}
                                                  editAction={this.props.editProduct}
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

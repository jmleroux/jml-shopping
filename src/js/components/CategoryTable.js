import * as React from "react";

class CategoryRow extends React.Component {

    onEdit(category) {
        this.props.editAction(category);
    }

    onDelete(category) {
        this.props.deleteAction(category);
    }

    render() {
        const category = this.props.category;
        return (
            <tr>
                <td className="category-name">{category.name}</td>
                <td className="category-operations">
                    <button type="button" className="btn btn-default btn-xs" onClick={() => this.onEdit(category)}>
                        <span className="glyphicon glyphicon-edit"/>
                    </button>
                    <button type="button" className="btn btn-default btn-xs" onClick={() => this.onDelete(category)}>
                        <span className="glyphicon glyphicon-trash"/>
                    </button>
                </td>
            </tr>
        );
    }
}

export default class CategoryTable extends React.Component {

    constructor(props) {
        super(props);

        this.emptyCategory = {
            id: null,
            name: ''
        };

        this.state = {category: Object.assign({}, this.emptyCategory)};
        this.handleChange = this.handleChange.bind(this);
    }

    componentDidMount() {
        const {username} = this.props;
        if (username) {
            this.props.listCategories();
        }
    }

    handleClick() {
        this.props.addCategory(this.state.category);
        this.setState({category: Object.assign({}, this.emptyCategory)});
    }

    handleChange(event) {
        const category = this.state.category;
        const inputName = event.target.name;
        category[inputName] = event.target.value;
        this.setState({category: category});
    }

    render() {
        const {username} = this.props;
        const rows = [];
        if (username) {
            return (
                <table className="table table-condensed">
                    <thead>
                    <tr>
                        <th className="category-name">Name</th>
                        <th className="category-operations"/>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type='text'
                                   className='form-control todo__entry'
                                   name='name'
                                   value={this.state.category.name}
                                   onChange={this.handleChange}
                        /></td>
                        <td>
                            <button type="submit" className="btn btn-default btn-sm" onClick={() => this.handleClick()}>
                                <span className="glyphicon glyphicon-ok-circle"/>
                            </button>
                        </td>
                        <td/>
                    </tr>
                    {this.props.categories.forEach(
                        (category) => {
                            rows.push(<CategoryRow key={category.id}
                                                  category={category}
                                                  editAction={this.props.editCategory}
                                                  deleteAction={this.props.deleteCategory}/>);
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

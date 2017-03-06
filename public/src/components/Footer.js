import * as React from "react";

export default class Footer extends React.Component {

    constructor(props) {
        super(props);
        this.clickClearAll = this.clickClearAll.bind(this);
    }

    clickClearAll() {
        this.props.clearAll();
    }

    render() {
        const {username} = this.props;
        if (username) {
            return (
                <div>
                    <button type="button" className="btn btn-default btn-sm" onClick={this.clickClearAll}>
                        <span className="glyphicon glyphicon-ok-circle"/> Clear All
                    </button>
                </div>
            );
        }
    }
}

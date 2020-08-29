import * as React from "react";

class Login extends React.Component {
    handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        this.props.onLogin(username, password);
    }

    render() {
        return (
            <form className="form-inline my-2 my-lg-o">
                    <input id="username" className="form-control mr-sm-2" type="text" placeholder="Login"/>
                    <input id="password" className="form-control mr-sm-2" type="password" placeholder="Password"/>
                <button className="btn btn-outline-success my-2 my-sm-0" type="sumbmit" onClick={(event) => this.handleLogin(event)}>
                    OK
                </button>
            </form>
        );
    }
}

class Menu extends React.Component {
    handleLogout() {
        this.props.onLogout();
    }

    render() {
        const {username, errorMessage} = this.props;
        return (
            <div>
                <ul className="nav navbar-nav navbar-left">
                    <li className="nav-item"><a className="nav-link" href="#/product-list">Products</a></li>
                    <li className="nav-item"><a className="nav-link" href="#/category-list">Categories</a></li>
                </ul>
                <ul className="nav navbar-nav navbar-right">
                    <li className="nav-item"><a className="nav-link" href="#">{username}</a></li>
                    <li className="nav-item"><a className="nav-link" href="#" onClick={() => {
                        this.handleLogout()
                    }}>Logout</a></li>
                </ul>
            </div>
        );
    }
}

export default class Navbar extends React.Component {
    render() {
        const {login, logout, username, errorMessage} = this.props;

        if (!username) {
            return (<Login errorMessage={errorMessage} onLogin={login}/>);
        } else {
            return (<Menu onLogout={logout} username={username}/>);
        }
    }
}

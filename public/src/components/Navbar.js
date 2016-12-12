import * as React from "react";

class Login extends React.Component {
    handleLogin() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        this.props.onLogin(username, password);
    }

    render() {
        return (
            <div>
                <div className="navbar-form navbar-right">
                    <div className="form-group">
                        <input type="text" id="username" className="form-control input-sm"
                               placeholder="login"/>
                    </div>
                    <div className="form-group">
                        <input type="password" id="password" className="form-control input-sm"
                               placeholder="password"/>
                    </div>
                    <div className="form-group">
                        <button type="button" className="btn btn-default" onClick={() => this.handleLogin()}>
                            <span className="glyphicon glyphicon-ok-circle"/>
                        </button>
                    </div>
                </div>
            </div>
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
                <ul className="nav navbar-nav">
                    <li><a href="#/product-list">Products</a></li>
                    <li><a href="#/category-list">Categories</a></li>
                </ul>
                <div className="navbar-form navbar-right">
                    <div className="navbar-collapse navbar-right">
                        <ul className="nav navbar-nav">
                            <li>{username}</li>
                            <li><a href="#" onClick={() => {
                                this.handleLogout()
                            }}>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        );
    }
}

export default class Navbar extends React.Component {
    render() {
        const {login, logout, username, errorMessage} = this.props;

        return (
            <div>
                {!username &&
                <Login
                    errorMessage={errorMessage}
                    onLogin={login}
                />
                }

                {username &&
                <Menu onLogout={logout}
                      username={username}
                />
                }
            </div>
        );
    }
}

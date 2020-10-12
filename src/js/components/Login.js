import React, {useContext} from 'react';
import {GoogleLogin} from 'react-google-login';

import store, {authSuccess} from "../store";

const clientId = '157938711281-pqfq286sic3gjja0cm9cokl5fe6fdlhd.apps.googleusercontent.com';

function Login() {
    console.log('start login');
    const {state, dispatch} = useContext(store);

    const onSuccess = (res) => {
        console.log('Login Success: result:', res);
        console.log('Login Success: currentUser:', res.profileObj);
        dispatch(authSuccess({
            accessToken: res.accessToken,
            username: res.profileObj.email,
            avatar: res.profileObj.imageUrl,
        }))
    };

    const onFailure = (res) => {
        console.log('Login failed: res:', res);
    };

    return (
        <div>
            <GoogleLogin
                clientId={clientId}
                buttonText="Login"
                onSuccess={onSuccess}
                onFailure={onFailure}
                cookiePolicy={'single_host_origin'}
                style={{marginTop: '100px'}}
                isSignedIn={true}
            />
        </div>
    );
}

export default Login;

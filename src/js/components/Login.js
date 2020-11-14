import React, {useContext} from 'react';
import {GoogleLogin} from 'react-google-login';

import store, {authSuccess} from "../store";
import apiUser from "../apiUser";

const clientId = process.env.GOOGLE_CLIENT_ID;

function Login() {
    const {dispatch} = useContext(store);

    const onSuccess = async (res) => {
        console.info('Login Success: result:', res);
        const response = await apiUser.isAuthorized(res.accessToken)
        if (200 === response.status) {
            console.info('Dispatching auth success');
            dispatch(authSuccess({
                accessToken: res.accessToken,
                username: res.profileObj.email,
                avatar: res.profileObj.imageUrl,
            }))
        }
    };

    const onFailure = (res) => {
        console.error('Login failed: res:', res);
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

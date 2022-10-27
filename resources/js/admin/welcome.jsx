import React from 'react';
import './welcome.css';

export default function Welcome() {
    return (<div className='welcomeScreen'>
        <h1>Welcome back, {js_data['user_name']}</h1>
        </div>)
}

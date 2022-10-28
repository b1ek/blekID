import React, { useState } from 'react';

import Users from './users.jsx';
import Apps from './apps.jsx';

import NewUser from './new_user.jsx';
import NewApp from './new_app.jsx';

import Welcome from './welcome.jsx';

import { useCookies } from 'react-cookie';
import './panel.css';

const Table = (e) => {return (<table><tbody>{{...e.children}}</tbody></table>);};

export default function Panel(props) {

    /*const [cookie, setCookie] = useCookies(['adminPanelLastRoute']);

    let startRoute = 'welcome';
    if (cookie.adminPanelLastRoute !== undefined) {
        startRoute = cookie.adminPanelLastRoute;
    }*/

    const [route, setRoute] = useState('welcome');

    function FsetRoute(new_route) {
        // setCookie('adminPanelLastRoute', new_route);
        setRoute(new_route);
    }

    const Routes = {
        users: <Users setRoute={FsetRoute} />,
        apps: <Apps setRoute={FsetRoute} />,
        welcome: <Welcome />,
        newUser: <NewUser />,
        newApp: <NewApp />,
    }

    return (
        <div className='panel_main'>
            <p className='title'>
                Admin panel
            </p>
            <Table>
                <tr>
                    <td className='panel left'>
                        <ul className='panel_links'>
                            <li><a href='#' onClick={() => {FsetRoute('users')}}>Users</a></li>
                            {js_data.god_mode ? <li><a href='#' onClick={() => {FsetRoute('apps')}}>Apps</a></li> : null}
                        </ul>
                    </td>
                    <td className='panel right'>
                        {Routes[route]}
                    </td>
                </tr>
            </Table>
        </div>
    );
}

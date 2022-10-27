import React from 'react';
import PanelComponent from './component/panel_component.jsx';
import './users.css';
import './7.css';

const UserRow = (props) => {
    const d = props.d;
    const i = props.i;
    const uid = d.id;

    const deleteAction = () => {

        let consent = false;

        if (d.deleted)
            consent = confirm("The user is deleted already. Do you want to restore the account?");
        else
            consent = confirm("Are you sure want to delete the user?");

        if (!consent) return;

        fetch('/api/admin/delete/' + uid).then(() => {props.reload()});
    };
    const freezeAction = () => {
        let consent = confirm("Are you sure want to freeze this user?");
        if (!consent) return;
        fetch('/api/admin/freeze/' + uid).then(() => {props.reload()});
    };
    const passwdAction = () => {};
    const pencilAction = () => {};


    let bg = 'white';
    if (d.deleted) bg = 'lightgray';
    if (d.frozen) bg = 'lightblue';


    return (
        <tr key={i} style={{background: bg}}>
            <td>
                <a href='#' onClick={deleteAction}><img src="/static/ico/delete.png" title='Delete user'></img></a>
                <a href='#' onClick={freezeAction}><img src="/static/ico/pause.png" title='Freeze user account'></img></a>
                <a href='#' onClick={passwdAction}><img src="/static/ico/key.png" title='Change password'></img></a>
                <a href='#' onClick={pencilAction}><img src="/static/ico/edit.png" title='Edit user'></img></a>
            </td>
            <td><a id={'user_' + uid}></a>{d.id}</td>
            <td>{d.login}</td>
            <td>{d.email}</td>
            <td>{d.ip}</td>
            <td>{d["user-agent"]}</td>
            <td>{d.created}</td>
            <td>{new Date(d.created).toUTCString()}</td>
            <td>{d["registrator-app"]}</td>
        </tr>);
};

export default class Users extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            reloaded: Date.now(),
            userData: {
                loaded: false,
            }
        }

        fetch('/api/admin/get_all_users').then((data)=>data.json()).then((data) => {
            this.setState({
                userData: {
                    loaded: true,
                    users: data,
                }
            });
        });

        this.reloadUsers = this.reloadUsers.bind(this);
    }

    reloadUsers() {
        fetch('/api/admin/get_all_users').then((data)=>data.json()).then((data) => {
            this.setState({
                userData: {
                    loaded: true,
                    users: data,
                }
            });
        });

        this.setState({
            userData: {
                loaded: false,
            }
        });
    }

    render () {

        const newUser = () => {
            this.props.setRoute('newUser');
        };

        return (
            <PanelComponent title='Users' className='userpanel'>
                <p>User control panel (<a href='#' onClick={() => {}}>Reload</a>)</p>

                <p style={{margin:'6px 0','...button': {margin: 3}}}>
                <button onClick={newUser}>Add new user...</button>
                </p>
                {
                    this.state.userData.loaded == false ?
                        <p align='center'>Please wait, user data is being loaded...<br/><img src='/static/loading.gif'></img></p>
                        :
                        <table width={300}>
                            <tbody>
                                <tr>
                                    <td>actions</td>
                                    <td>id</td>
                                    <td>login</td>
                                    <td>email</td>
                                    <td>ip</td>
                                    <td>user agent</td>
                                    <td>created (timestamp)</td>
                                    <td>created (readable)</td>
                                    <td>registrator</td>
                                </tr>
                                {
                                    this.state.userData.users.map((d, i) => {
                                        return <UserRow d={d} i={i} reload={this.reloadUsers} />
                                    })
                                }
                            </tbody>
                        </table>
                }
            </PanelComponent>
        );
    }
}

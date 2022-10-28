import React from 'react';
import PanelComponent from './component/panel_component.jsx';
import './users.css';
import './7.css';
import copy from 'copy-to-clipboard';

export default class Apps extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            appData: {
                loading: true,
                data: []
            }
        }

        this.loadData = this.loadData.bind(this);
        this.search = this.search.bind(this);
        this.searchQuery = React.createRef();
    }

    loadData() {
        fetch('/api/admin/get_all_apps').then(data => data.json()).then(data => {
            this.setState({
                appData: {
                    loading: false,
                    data: data,
                }
            });
        });
        this.setState({
            appData: {loading: true}
        });
    }

    componentDidMount() {
        this.loadData();
    }

    search() {
        this.setState({
            searchQuery: this.searchQuery.current.value
        });
    }

    render() {
        if (js_data.god_mode)
        return (
            <PanelComponent title='Apps' className='userpanel'>
                <p>
                    <button onClick={this.loadData}>Refresh</button>
                    <button onClick={() => this.props.setRoute('newApp')}>Create new app...</button>
                </p>
                <p style={{margin:8}}>
                    Search app: <input type='text' ref={this.searchQuery}></input>
                    <button onClick={this.search}>Search</button>
                </p>

                {
                    this.state.appData.loading ?

                    <p align='center'>
                        Please wait, data is being loaded<br/>
                        <img src='/static/loading.gif'></img>
                    </p> :

                    <table>
                        <tbody>
                            <tr key={0}>
                                <td>actions</td>
                                <td>id</td>
                                <td>name</td>
                                <td>public name</td>
                                <td>contact</td>
                                <td>link</td>
                            </tr>
                            {
                                this.state.appData.data.map((data, i) => {
                                    if (this.state.searchQuery) {
                                        if (data.name.match('.*' + this.state.searchQuery + '.*') == null) {
                                            return null;
                                        }
                                    }

                                    const suspend = () => {
                                        let consent = confirm('Are you sure want to ' + (data.suspended ? 'un-' : '') + 'suspend ' + data.public_name + '?');
                                        if (!consent) return;
                                        fetch('/api/admin/suspend_app/' + data.id).then(d => this.loadData());
                                        this.setState({appData:{loading:true}});
                                    };
                                    const revokes = () => {
                                        let consent = confirm('Are you sure want to revoke ' + data.public_name + '\'s secret?');
                                        if (!consent) return;
                                        let consent2 = confirm('Warning: this WILL break the app\'s communication with the API.\nYou shouldn\'t do it if not absolutely necessary.\n\nPress OK only if you know EXACTLY what you are doing.');
                                        if (!consent2) return;
                                        fetch('/api/admin/revoke_secret/' + data.id).then(d => d.text()).then(d => {
                                            copy(d);
                                            prompt(data.public_name + '\' secret was revoked and the new key was copied to your clipboard. If you copied something else, the new secret is present below:', d);
                                        });
                                        //this.setState({appData:{loading:true}});
                                    };

                                    let bg = 'white';

                                    if (data.suspended) bg = 'lightgray';

                                    return (
                                        <tr key={i+1} style={{backgroundColor: bg}}>
                                            <td>
                                                <a href='#' onClick={suspend}>{data.suspended ? 'UnSuspend' : 'Suspend'}</a><br/>
                                                <a href='#' onClick={revokes}>Revoke secret</a>
                                            </td>
                                            <td>{data.id}</td>
                                            <td>{data.name}</td>
                                            <td>{data.public_name}</td>
                                            <td>{data.contact}</td>
                                            <td>{data.link}</td>
                                        </tr>
                                    );
                                })
                            }
                        </tbody>
                    </table>
                }

            </PanelComponent>
        );
        else return (
            <PanelComponent title='Apps'>
                <p align='center'>
                    Access denied
                </p>
            </PanelComponent>
        );
    }
}

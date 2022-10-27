import React from 'react';
import PanelComponent from './component/panel_component.jsx';
import { Formik, Field, Form } from 'formik';

export default class NewUser extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            apps: {
                loaded: false
            }
        }
        fetch('/api/admin/get_all_apps').then((data) => data.json()).then((data) => {
            this.setState({
                apps: {
                    loaded: true,
                    data: data
                }
            });
        });
    }

    render() {
        return (
            <PanelComponent title='New user'>
                <Formik

                initialValues={{
                    login: '',
                    password: '',
                    email: '',
                    registrator: 0,
                    ip: '',
                    userag: '',
                }}
                onSubmit={(vals) => {
                    console.log(vals);
                }}
                >

                <Form>
                    <table style={{minHeight:0}}>
                        <tbody align='center'>
                            <tr>
                                <td><label htmlFor="login">Login</label></td>
                                <td><Field id="login" name="login" type='text' placeholder="CoolGuy83" /></td>
                            </tr>
                            <tr>
                                <td><label htmlFor="password">Password</label></td>
                                <td><Field id="password" name="password" type='text' placeholder='supersecurepassword' /></td>
                            </tr>
                            <tr>
                                <td><label htmlFor="email">Email</label></td>
                                <td><Field id="email" name="email" type='text' placeholder='CoolGuy@gmail.com' /></td>
                            </tr>
                            <tr>
                                <td><label htmlFor="ip">IP</label></td>
                                <td><Field id="ip" name="ip" type='text' placeholder='127.0.0.1' /></td>
                            </tr>
                            <tr>
                                <td><label htmlFor="userag">User agent</label></td>
                                <td><Field id="userag" name="userag" type='text' placeholder='Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36' /></td>
                            </tr>
                            <tr>
                                <td><label htmlFor="registrator">Registrator</label></td>
                                <td>
                                    {
                                        this.state.apps.loaded
                                        ?

                                        <Field as='select' name='registrator'>
                                            {
                                                this.state.apps.data.map((d, i) => {
                                                    return <option value={d.id}>{d["public_name"]}</option>;
                                                })
                                            }
                                        </Field>

                                        : <p>Please wait, loading apps...</p>
                                    }
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="submit">Submit</button>
                </Form>

                </Formik>
            </PanelComponent>
        )
    }
}

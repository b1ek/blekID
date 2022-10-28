import React from 'react';
import PanelComponent from './component/panel_component.jsx';
import { Formik, Field, Form } from 'formik';

export default class NewApp extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <PanelComponent title='New app'>
                <Formik

                initialValues={{
                    name: 'blek_msg',
                    pubName: 'blek! Messenger',
                    contact: 'me@blek.codes',
                    link: 'msg.blek.codes',
                }}
                onSubmit={(vals) => {
                    fetch('/api/admin/create_app', {
                        method: 'POST',
                        body: JSON.stringify(vals)
                    }).then(data => data.json()).then(data => {
                        if (!data.success) {
                            alert('Failed, :(');
                            return;
                        }
                        copy(data.secret);
                        prompt('App created! Its secret key:', data.secret);
                    });
                }}
                >
                    <Form>
                        <table style={{minHeight:0}}>
                            <tbody align='center'>
                                <tr>
                                    <td><label htmlFor="name">Name</label></td>
                                    <td><Field id="name" name="name" type='text' placeholder="internal_name" /></td>
                                </tr>
                                <tr>
                                    <td><label htmlFor="pubName">Public name</label></td>
                                    <td><Field id="pubName" name="pubName" type='text' placeholder="Public Name" /></td>
                                </tr>
                                <tr>
                                    <td><label htmlFor="contact">Contacts</label></td>
                                    <td><Field id="contact" name="contact" type='text' placeholder="devs@app.com" /></td>
                                </tr>
                                <tr>
                                    <td><label htmlFor="link">Link to website</label></td>
                                    <td><Field id="link" name="link" type='text' placeholder="app.com" /></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>
                            <button type='submit'>Submit</button>
                        </p>
                    </Form>

                </Formik>
            </PanelComponent>
        )
    }
}

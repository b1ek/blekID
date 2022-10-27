import React from 'react';
import './panel_style.css';

const styles = {
    title: {
        padding: '4px 16px',
        margin: 0,
        background: '#f2f4f2',
        borderBottom: '1px solid #c2c4c2',
        fontSize: 14,
    }
};

export default class PanelComponent extends React.Component {
    /*construct(props) {
        this.prop = props;
    }*/
    render() {
        let no_title = this.props.no_title;
        if (this.props.no_title == undefined) no_title = false;
        if (this.props.title == undefined) no_title = true;

        return (
            <div className='panel_component'>
                {
                    no_title ? null
                        : <h1 style={styles.title}>{this.props.title}</h1>
                }
                <div className={'panel_body' + (this.props.className ? ' ' + this.props.className : '')}>{this.props.children}</div>
            </div>
        );
    }
}

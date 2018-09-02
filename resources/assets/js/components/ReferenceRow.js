import React from 'react';

export default class ReferenceRow extends React.Component {
    constructor() {
        super();
    }

    render() {
        return (
            <tr>
                <td>{ this.props.reference.reference }</td>
                <td>{ this.props.reference.email }</td>
                <td>
                    <button className="btn btn-info" onClick={ this.props.callback.bind(this, this.props.reference.reference) }>Providers</button>
                </td>
            </tr>
        );
    }
}

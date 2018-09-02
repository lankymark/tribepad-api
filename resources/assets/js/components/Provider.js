import React from 'react';

export default class Provider extends React.Component {
    constructor() {
        super();
    }

    render() {
        return (
            <tr>
                <td>{ this.props.provider.provider }</td>
                <td>{ this.props.provider.status }</td>
                <td>{ this.props.provider.score }</td>
                <td>{ this.props.provider.failed }</td>
            </tr>
        );
    }
}

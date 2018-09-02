import React from 'react';
import axios from 'axios';
import { Col, Row } from 'react-bootstrap';

import { deleteReferencesURL, getReferencesURL, getReferenceProvidersURL } from "../api/apiURLs";
import ReferenceRow from "./ReferenceRow";
import Provider from "./Provider";

export default class ReferencesList extends React.Component {
    constructor() {
        super();
        this.state = {
            data: [],
            deleteURL: deleteReferencesURL,
            url: getReferencesURL,
            pagination: [],
            providers: [],
            providersURL: getReferenceProvidersURL,
            reference: false
        };
    }

    componentWillMount() {
        this.fetchReferences();
    }

    deleteReference() {
        axios.delete(this.state.deleteURL).then(response => {
            this.fetchReferences();
            this.setState({
                deleteURL: deleteReferencesURL,
                providersURL: getReferenceProvidersURL,
                reference: false
            });
        }).catch(error => {
           console.log(error);
        });
    }

    emailSearch(e) {
        let $this = this;

        this.setState({
            url: getReferencesURL+'/'+e.target.value
        }, function() {
            $this.fetchReferences();
        });
    }

    fetchProviders() {
        axios.get(this.state.providersURL).then(response => {
            this.setState({
               providers: response.data.data
            });
        }).catch(error => {
            console.log(error);
        });
    }

    fetchReferences() {
        let $this = this;

        axios.get(this.state.url).then(response => {
            this.setState({
                data: response.data.data
            });

            $this.makePagination(response.data);
        }).catch(error => {
            console.log(error);
        });
    }

    first() {
        let $this = this;

        this.setState({
            url: this.state.pagination.first_page_url
        }, function() {
            $this.fetchReferences();
        });
    }

    last() {
        let $this = this;

        this.setState({
            url: this.state.pagination.last_page_url
        }, function() {
            $this.fetchReferences();
        });
    }

    makePagination(data) {
        let pagination = {
            current_page: data.meta.current_page,
            last_page: data.meta.last_page,
            first_page_url: data.links.first,
            next_page_url: data.links.next,
            previous_page_url: data.links.prev,
            last_page_url: data.links.last
        };

        this.setState({
           pagination: pagination
        });
    }

    next() {
        let $this = this;

        this.setState({
            url: this.state.pagination.next_page_url
        }, function() {
            $this.fetchReferences();
        });
    }

    previous() {
        let $this = this;

        this.setState({
            url: this.state.pagination.previous_page_url
        }, function() {
            $this.fetchReferences();
        });
    }

    providersList() {
        if (this.state.reference !== false) {
            return this.state.providers.map((row,key) => (
                <Provider key={ key } provider={ row } reference={ this.state.reference } />
            ));
        }
    }

    tableList() {
        return this.state.data.map((row,key) => (
            <ReferenceRow key={ key } reference={ row } callback={ this.updateReference.bind(this) } />
        ));
    }

    updateReference(reference, e) {
        let $this = this;

        this.setState({
            deleteURL: deleteReferencesURL+'/'+reference,
            providersURL: getReferenceProvidersURL+'/'+reference,
            reference: reference
        }, function() {
            $this.fetchProviders();
        });
    }

    render() {
        return (
            <Row>
                <Col lg={6} md={6}>
                    <h2 className="page-header">Reference List</h2>
                    <input className="form-control" type="text" name="email-search" onKeyUp={ this.emailSearch.bind(this) } placeholder="Email Search"/>
                    <table>
                        <thead>
                            <tr>
                                <th># Reference</th>
                                <th>@ Email</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        { this.tableList() }
                        </tbody>
                    </table>
                    <button className="btn mt-3 mr-3" onClick={ this.first.bind(this) } disabled={ this.state.pagination.first_page_url === null }>First Page</button>
                    <button className="btn mt-3 mr-3" onClick={ this.previous.bind(this) } disabled={ this.state.pagination.previous_page_url === null }>Previous Page</button>
                    <button className="btn mt-3 mr-3" onClick={ this.next.bind(this) }  disabled={ this.state.pagination.next_page_url === null }>Next Page</button>
                    <button className="btn mt-3 mr-3" onClick={ this.last.bind(this) } disabled={ this.state.pagination.last_page_url === null }>Last Page</button>
                    <br/>
                    <div>
                        Page { this.state.pagination.current_page } of { this.state.pagination.last_page }
                    </div>
                </Col>
                <Col lg={6} md={6} >
                    <h2 className="page-header">#{ this.state.reference } Providers</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Failed</th>
                        </tr>
                        </thead>
                        <tbody>
                        { this.providersList() }
                        </tbody>
                    </table>
                    <button className="btn btn-danger mt-3 mr-3" onClick={ this.deleteReference.bind(this) } disabled={ this.state.reference === false }>Delete Reference</button>
                </Col>
            </Row>
        );
    }
}

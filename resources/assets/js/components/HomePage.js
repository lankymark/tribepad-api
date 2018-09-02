import React from 'react';
import { Grid, Col, Row } from 'react-bootstrap';
import ReferencesList from "./ReferencesList";

export default class HomePage extends React.Component{

    render(){
        return (
        <Grid className={"minimum-height home-page-div"}>
            <Row>
                <Col lg={12} md={12}>
                    Hi Tribepad
                </Col>

                <Col lg={12} md={12} className={'temp'}>
                    <ReferencesList/>
                </Col>
            </Row>
        </Grid>
        )
    }
}

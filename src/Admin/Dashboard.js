import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb } from 'react-bootstrap'

class Dashboard extends Component {
   constructor() {
      super()

      this.state = {
         categories: 0,
         profile: 0,
         blog: 0
      }
   }

   componentDidMount() {
      this.setState({ ...content.counting })
   }

   render() {
      return (
         <Container fluid={true}>
            <Row className="page-titles">
               <Col md={12} className="align-self-center">
                  <h4 className="text-themecolor m-b-0 m-t-0">Dashboard</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>{document.getElementsByTagName('title')[0].innerText}</Breadcrumb.Item>
                  </Breadcrumb>
               </Col>
            </Row>
            <Row>
               <Col lg={4} md={12}>
                  <div className="card card-inverse card-primary">
                     <div className="card-body">
                        <div className="d-flex">
                           <h3 className="card-title">Categories</h3>
                        </div>
                        <Row>
                           <div className="col-4 align-self-center">
                              <h2 className="font-weight-light text-white text-nowrap">{this.state.categories} categories</h2>
                           </div>
                        </Row>
                     </div>
                  </div>
               </Col>
               <Col lg={4} md={12}>
                  <div className="card card-inverse card-success">
                     <div className="card-body">
                        <div className="d-flex">
                           <h3 className="card-title">Profile</h3>
                        </div>
                        <Row>
                           <div className="col-4 align-self-center">
                              <h2 className="font-weight-light text-white text-nowrap">{this.state.profile} profile</h2>
                           </div>
                        </Row>
                     </div>
                  </div>
               </Col>
               <Col lg={4} md={12}>
                  <div className="card card-inverse card-info">
                     <div className="card-body">
                        <div className="d-flex">
                           <h3 className="card-title">Blog</h3>
                        </div>
                        <Row>
                           <div className="col-4 align-self-center">
                              <h2 className="font-weight-light text-white text-nowrap">{this.state.blog} blog</h2>
                           </div>
                        </Row>
                     </div>
                  </div>
               </Col>
            </Row>
         </Container>
      )
   }
}

ReactDOM.render(<Dashboard />, document.getElementById('root'))
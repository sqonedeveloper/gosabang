import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Button, Form } from 'react-bootstrap'
import axios from 'axios'
import MsgResponse from '../../MsgResponse'

axios.defaults.baseURL = siteURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

class Forms extends Component {
   constructor() {
      super()
   
      this.state = {
         btnLoading: false,
         errors: {},
         status: false,
         msg_response: '',
         name: '',
         icon: ''
      }
   
      this._onChange = this._onChange.bind(this)
   }

   componentDidMount() {
      if (pageType === 'update') {
         this.setState({ ...content.detail })
      }
   }
   
   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })

      if (e.target.name === 'icon') {
         var input = this.icon.files[0]
         var size = input.size / 1000

         if (size >= 2000) {
            this.setState({
               errors: {
                  icon: 'File too large?'
               }
            })
         } else {
            this.setState({ errors: {
               icon: ''
            } })
         }
      }
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('pageType', pageType)
      formData.append('id', segment[4])
      formData.append('name', this.state.name)
      formData.append('icon', this.icon.files[0])
      
      axios.
         post('/admin/categories/submit', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })

            if (response.status) {
               if (pageType === 'insert') {
                  this.setState({ ...response.emptyPost })
               }
            }
         }).
         catch(error => {
            console.log('Error', error.message)
         }).
         finally(() => {
            this.setState({ btnLoading: false })
         })
   }

   render() {
      return (
         <Container fluid={true}>
            <Row className="page-titles">
               <Col md={12} className="align-self-center">
                  <h4 className="text-themecolor m-b-0 m-t-0">Categories</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>Categories</Breadcrumb.Item>
                     <Breadcrumb.Item active>{document.getElementsByTagName('title')[0].innerText}</Breadcrumb.Item>
                  </Breadcrumb>
               </Col>
            </Row>
            <Row>
               <Col md={12}>
                  <MsgResponse {...this.state} />
                  <div className="card">
                     <div className="card-body">
                        <Form.Group as={Row} className={this.state.errors.name ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Name</Form.Label>
                           <Col md={10}>
                              <Form.Control name="name" value={this.state.name} onChange={this._onChange} size="sm" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.name}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.icon ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Icons</Form.Label>
                           <Col md={10}>
                              <Form.Control name="icon" ref={e => this.icon = e} onChange={this._onChange} size="sm" type="file" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.icon}</Form.Control.Feedback>
                              <Form.Control.Feedback type="valid">Files can only be 2MB</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Col md={{ offset: 2, span: 10 }}>
                           <Button
                              variant="success"
                              className="waves-effect waves-light"
                              size="sm"
                              onClick={this.state.btnLoading ? null : this._submit.bind(this)}
                           >{this.state.btnLoading ? 'Loading...' : 'Submit'}</Button>
                        </Col>
                     </div>
                  </div>
               </Col>
            </Row>
         </Container>
      )
   }
}

ReactDOM.render(<Forms />, document.getElementById('root'))
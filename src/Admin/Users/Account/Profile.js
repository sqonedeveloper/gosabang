import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Form, Button } from 'react-bootstrap'
import axios from 'axios'
import MsgResponse from '../../../MsgResponse'

axios.defaults.baseURL = siteURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

class Profile extends Component {
   constructor() {
      super()

      this.state = {
         btnLoading: false,
         errors: {},
         status: false,
         msg_response: '',
         name: '',
         username: '',
         email: '',
         password: '',
         confirm_password: ''
      }

      this._onChange = this._onChange.bind(this)
   }

   componentDidMount() {
      this.setState({ ...content.detail })
   }

   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('name', this.state.name)
      formData.append('username', this.state.username)
      formData.append('email', this.state.email)
      formData.append('password', this.state.password)
      formData.append('confirm_password', this.state.confirm_password)

      axios.
         post('/admin/users/profile/submit', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })
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
                  <h4 className="text-themecolor m-b-0 m-t-0">Users</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>Users</Breadcrumb.Item>
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
                           <Form.Label column md={3}>Fullname</Form.Label>
                           <Col md={9}>
                              <Form.Control name="name" value={this.state.name} onChange={this._onChange} size="sm" autoFocus />
                              <Form.Control.Feedback type="invalid">{this.state.errors.name}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.username ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Username</Form.Label>
                           <Col md={9}>
                              <Form.Control value={this.state.username} size="sm" disabled={true} />
                              <Form.Control.Feedback type="invalid">{this.state.errors.username}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.email ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Email</Form.Label>
                           <Col md={9}>
                              <Form.Control value={this.state.email} size="sm" disabled={true} />
                              <Form.Control.Feedback type="invalid">{this.state.errors.email}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.password ? 'has-danger' : ''}>
                           <Form.Label column md={3}>New Password</Form.Label>
                           <Col md={9}>
                              <Form.Control name="password" value={this.state.password} onChange={this._onChange} size="sm" type="password" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.password}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.confirm_password ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Confirm New Password</Form.Label>
                           <Col md={9}>
                              <Form.Control name="confirm_password" value={this.state.confirm_password} onChange={this._onChange} size="sm" type="password" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.confirm_password}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Col md={{ offset: 3, span: 9 }}>
                           <Button
                              variant="success"
                              className="waves-effect waves-light"
                              size="sm"
                              onClick={this.state.btnLoading ? null : this._submit.bind(this)}
                           >{this.state.btnLoading ? 'Loading...' : 'Update'}</Button>
                        </Col>
                     </div>
                  </div>
               </Col>
            </Row>
         </Container>
      )
   }
}

ReactDOM.render(<Profile />, document.getElementById('root'))
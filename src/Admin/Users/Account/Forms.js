import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Button, Form } from 'react-bootstrap'
import MsgResponse from '../../../MsgResponse'
import axios from 'axios'

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
         username: '',
         email: '',
         password: '',
         role: '',
         id_profile_usaha: '',
         status: '1'
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
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('pageType', pageType)
      formData.append('id', segment[5])
      formData.append('name', this.state.name)
      formData.append('username', this.state.username)
      formData.append('email', this.state.email)
      formData.append('password', this.state.password)
      formData.append('role', this.state.role)
      formData.append('id_profile_usaha', this.state.id_profile_usaha)
      formData.append('status', this.state.status)

      axios.
         post('/admin/users/account/submit', formData).
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
                  <h4 className="text-themecolor m-b-0 m-t-0">Users</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>Users</Breadcrumb.Item>
                     <Breadcrumb.Item active>Account</Breadcrumb.Item>
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
                           <Form.Label column md={2}>Fullname</Form.Label>
                           <Col md={10}>
                              <Form.Control name="name" value={this.state.name} onChange={this._onChange} size="sm" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.name}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.username ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Username</Form.Label>
                           <Col md={10}>
                              <Form.Control name="username" value={this.state.username} onChange={this._onChange} size="sm" disabled={pageType === 'update' ? true : false} />
                              <Form.Control.Feedback type="invalid">{this.state.errors.username}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.email ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Email</Form.Label>
                           <Col md={10}>
                              <Form.Control name="email" value={this.state.email} onChange={this._onChange} size="sm" disabled={pageType === 'update' ? true : false} />
                              <Form.Control.Feedback type="invalid">{this.state.errors.email}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.password ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Password</Form.Label>
                           <Col md={10}>
                              <Form.Control name="password" value={this.state.password} onChange={this._onChange} size="sm" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.password}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.role ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Roles</Form.Label>
                           <Col md={10}>
                              <Form.Control name="role" value={this.state.role} onChange={this._onChange} size="sm" as="select" disabled={pageType === 'update' ? true : false}>
                                 <option value="">--choose--</option>
                                 <option value="1">Administrator</option>
                                 <option value="2">Profile</option>
                              </Form.Control>
                              <Form.Control.Feedback type="invalid">{this.state.errors.role}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.id_profile_usaha ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Profile</Form.Label>
                           <Col md={10}>
                              <Form.Control name="id_profile_usaha" value={this.state.id_profile_usaha} onChange={this._onChange} size="sm" as="select" disabled={this.state.role === '2' ? (pageType === 'update' ? true : false) : true}>
                                 <option value="">--choose--</option>
                                 {content.listsProfile.map((data, key) => {
                                    return <option value={data.value} key={key}>{data.label}</option>
                                 })}
                              </Form.Control>
                              <Form.Control.Feedback type="invalid">{this.state.errors.id_profile_usaha}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.status ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Status</Form.Label>
                           <Col md={10}>
                              <Form.Control name="status" value={this.state.status} onChange={this._onChange} size="sm" as="select">
                                 <option value="1">Active</option>
                                 <option value="0">Suspend</option>
                              </Form.Control>
                              <Form.Control.Feedback type="invalid">{this.state.errors.status}</Form.Control.Feedback>
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
import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Form, Row, Col, Button } from 'react-bootstrap'
import MsgResponse from './MsgResponse'
import axios from 'axios'
import { userRoles } from './Helper'

axios.defaults.baseURL = siteURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

class Login extends Component {
   constructor() {
      super()

      this.state = {
         btnLoading: false,
         errors: {},
         status: false,
         msg_response: ''
      }

      this._onChange = this._onChange.bind(this)
   }

   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('username', this.state.username)
      formData.append('password', this.state.password)

      axios.
         post('/login/submit', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })

            open(siteURL + '/' +  userRoles(response.role) + '/dashboard', '_parent')
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
         <div className="login-register">
            <div className="login-box card">
               <div className="card-body">
                  <MsgResponse {...this.state} />
                  <Form className="form-horizontal form-material">
                     <h3 className="p-2 rounded-title mb-3">Sign In</h3>
                     <Form.Group>
                        <Form.Control name="username" value={this.state.username} onChange={this._onChange} placeholder="Username" autoFocus />
                     </Form.Group>
                     <Form.Group>
                        <Form.Control name="password" value={this.state.password} onChange={this._onChange} placeholder="Password" type="password" />
                     </Form.Group>
                     <Form.Group>
                        <div className="d-flex no-block align-items-center">
                           <div className="ml-auto">
                              <a href="javascript:void(0)" id="to-recover" className="text-muted"><i className="fa fa-lock mr-1" /> Forgot pwd?</a>
                           </div>
                        </div>
                     </Form.Group>
                     <Form.Group className="text-center mt-3">
                        <Button
                           variant="info"
                           className="btn-block text-uppercase waves-effect waves-light"
                           size="lg"
                           onClick={this.state.btnLoading ? null : this._submit.bind(this)}
                        >{this.state.btnLoading ? 'Loading...' : 'Log In'}</Button>
                     </Form.Group>
                     <Row>
                        <Col xs={12} sm={12} md={12} className="mt-2 text-center">
                           <div className="social">
                              <Button
                                 className="btn btn-facebook text-white"
                                 title="Login with Facebook"
                              ><i className="fab fa-facebook-f" /></Button>
                              <Button
                                 className="btn btn-googleplus text-white"
                                 title="Login with Google"
                              ><i className="fab fa-google-plus-g" /></Button>
                           </div>
                        </Col>
                     </Row>
                  </Form>
               </div>
            </div>
         </div>
      )
   }
}

ReactDOM.render(<Login />, document.getElementById('wrapper'))
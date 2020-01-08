import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Form, Button, InputGroup } from 'react-bootstrap'
import axios from 'axios'
import MsgResponse from '../../../MsgResponse'

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
         address: '',
         phone: '',
         email: '',
         latitude: '',
         longtitude: '',
         thumbnail: '',
      }

      this._onChange = this._onChange.bind(this)
   }

   componentDidMount() {
      this.setState({ ...content.detail })
   }

   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })

      if (e.target.name === 'thumbnail') {
         var input = this.thumbnail.files[0]
         var size = input.size / 1000

         if (size >= 2000) {
            this.setState({
               errors: {
                  thumbnail: 'File too large?'
               }
            })
         } else {
            this.setState({ errors: {
               thumbnail: ''
            } })
         }
      }
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('name', this.state.name)
      formData.append('address', this.state.address)
      formData.append('phone', this.state.phone)
      formData.append('email', this.state.email)
      formData.append('latitude', this.state.latitude)
      formData.append('longtitude', this.state.longtitude)
      formData.append('thumbnail', this.thumbnail.files[0])
      formData.append('old_thumbnail', this.state.thumbnail)

      axios.
         post('/usaha/profile/info/submit', formData).
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
                  <h4 className="text-themecolor m-b-0 m-t-0">Profile</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>Profile</Breadcrumb.Item>
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
                           <Form.Label column md={3}>Name</Form.Label>
                           <Col md={9}>
                              <Form.Control name="name" value={this.state.name} onChange={this._onChange} size="sm" disabled={true} />
                              <Form.Control.Feedback type="invalid">{this.state.errors.name}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.address ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Address</Form.Label>
                           <Col md={9}>
                              <Form.Control name="address" value={this.state.address} onChange={this._onChange} size="sm" autoFocus />
                              <Form.Control.Feedback type="invalid">{this.state.errors.address}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.phone ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Phone</Form.Label>
                           <Col md={9}>
                              <Form.Control name="phone" value={this.state.phone} onChange={this._onChange} size="sm" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.phone}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.email ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Email</Form.Label>
                           <Col md={9}>
                              <Form.Control name="email" value={this.state.email} onChange={this._onChange} size="sm" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.email}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.latitude ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Google Map Latitude</Form.Label>
                           <Col md={9}>
                              <Form.Control name="latitude" value={this.state.latitude} onChange={this._onChange} size="sm" type="number" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.latitude}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.longtitude ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Google Map Longtitude</Form.Label>
                           <Col md={9}>
                              <Form.Control name="longtitude" value={this.state.longtitude} onChange={this._onChange} size="sm" type="number" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.longtitude}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.thumnail ? 'has-danger' : ''}>
                           <Form.Label column md={3}>Image Thumbnail</Form.Label>
                           <Col md={9}>
                              <InputGroup size="sm">
                                 <Form.Control name="thumbnail" ref={e => this.thumbnail = e} onChange={this._onChange} size="sm" type="file" className="form-control" />
                                 <InputGroup.Prepend style={{ cursor: 'pointer' }} title="Click to view image" onClick={() => open(baseURL + 'img/' + this.state.thumbnail, '_blank')}>
                                    <InputGroup.Text><i className="ti-image" /></InputGroup.Text>
                                 </InputGroup.Prepend>
                              </InputGroup>                              
                              <Form.Control.Feedback type="invalid">{this.state.errors.thumbnail}</Form.Control.Feedback>
                              <Form.Control.Feedback type="valid">Files can only be 2MB</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Col md={{ offset: 3, span: 9 }}>
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
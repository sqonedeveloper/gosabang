import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Form, Button } from 'react-bootstrap'
import axios from 'axios'
import MsgResponse from '../MsgResponse'

axios.defaults.baseURL = siteURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

class Gallery extends Component {
   constructor() {
      super()
   
      this.state = {
         btnLoading: false,
         errors: {},
         status: false,
         msg_response: '',
         name: '',
         detail: []
      }
   
      this._onChange = this._onChange.bind(this)
   }

   componentDidMount() {
      this.setState({ ...content })
   }
   
   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })

      if (e.target.name === 'file') {
         var input = this.file.files[0]
         var size = input.size / 1000

         if (size >= 2000) {
            this.setState({
               errors: {
                  file: 'Image file too large?'
               }
            })
         } else {
            this.setState({ errors: {
               file: ''
            } })
         }
      }
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('pageType', 'insert')
      formData.append('name', this.state.name)
      formData.append('file', this.file.files[0])
      
      axios.
         post('/usaha/gallery/submit', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })

            if (response.status) {
               this.setState({ ...response.emptyPost })
            }
         }).
         catch(error => {
            console.log('Error', error.message)
         }).
         finally(() => {
            this.setState({ btnLoading: false })
         })
   }

   _deleteImage(id, file) {
      if (confirm('Are you sure you want to delete?')) {
         this.setState({
            status: true,
            msg_response: 'Loading...'
         })
   
         var formData = new FormData()
         formData.append('pageType', 'delete')
         formData.append('id', id)
         formData.append('file', file)
         
         axios.
            post('/usaha/gallery/delete', formData).
            then(res => {
               var response = res.data
               this.setState({ ...response })
            }).
            catch(error => {
               console.log('Error', error.message)
            })
      }
   }

   render() {
      return (
         <Container fluid={true}>
            <Row className="page-titles">
               <Col md={12} className="align-self-center">
                  <h4 className="text-themecolor m-b-0 m-t-0">Gallery</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
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
                           <Form.Label column md={2}>Image Title</Form.Label>
                           <Col md={10}>
                              <Form.Control name="name" value={this.state.name} onChange={this._onChange} size="sm" autoFocus />
                              <Form.Control.Feedback type="invalid">{this.state.errors.name}</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Form.Group as={Row} className={this.state.errors.file ? 'has-danger' : ''}>
                           <Form.Label column md={2}>Image File</Form.Label>
                           <Col md={10}>
                              <Form.Control name="file" ref={e => this.file = e} onChange={this._onChange} size="sm" type="file" />
                              <Form.Control.Feedback type="invalid">{this.state.errors.file}</Form.Control.Feedback>
                              <Form.Control.Feedback type="valid">Files can only be 2MB</Form.Control.Feedback>
                           </Col>
                        </Form.Group>
                        <Col md={{ offset: 2, span: 10 }}>
                           <Button
                              variant="success"
                              className="waves-effect waves-light"
                              size="sm"
                              onClick={this.state.btnLoading ? null : this._submit.bind(this)}
                           >{this.state.btnLoading ? 'Uploading...' : 'Submit'}</Button>
                        </Col>
                     </div>
                  </div>
                  <div className="card">
                     <div className="card-body">
                        <Row className="zoom-gallery">
                           {this.state.detail.map((data, key) => {
                              return (
                                 <Col md={4} key={key}>
                                    <a href={data.path} title={data.name}>
                                       <img src={data.path} class="img-fluid" alt={data.name} />
                                    </a>
                                    <h6 className="mt-2">{data.name}</h6>
                                    <small
                                       onClick={this._deleteImage.bind(this, data.id, data.file)}
                                       className="text-danger"
                                       style={{ cursor: 'pointer' }}>Delete</small>
                                 </Col>
                              )
                           })}
                        </Row>
                     </div>
                  </div>
               </Col>
            </Row>
         </Container>
      )
   }
}

ReactDOM.render(<Gallery />, document.getElementById('root'))
import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Form, Button } from 'react-bootstrap'
import axios from 'axios'
import MsgResponse from '../../MsgResponse'
import 'trumbowyg'

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
         title: '',
         id_categories: ''
      }

      this._onChange = this._onChange.bind(this)
   }

   componentDidMount() {
      $.trumbowyg.svgPath = baseURL + 'plugins/tumbowyg/dist/ui/icons.svg';
      $('#trumbowyg').trumbowyg({
         autogrow: true,
         removeformatPasted: true
      })

      if (pageType === 'update') {
         this.setState({ ...content.detail })
         $('#trumbowyg').trumbowyg('html', content.detail.content)
      }
   }

   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('pageType', pageType)
      formData.append('id', segment[4])
      formData.append('title', this.state.title)
      formData.append('content', $('#trumbowyg').trumbowyg('html'))
      formData.append('id_categories', this.state.id_categories)

      axios.
         post('/admin/blog/submit', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })

            if (response.status) {
               if (pageType === 'insert') {
                  this.setState({ ...response.emptyPost })
                  $('#trumbowyg').trumbowyg('html', '')
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
                  <h4 className="text-themecolor m-b-0 m-t-0">Blog</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>Blog</Breadcrumb.Item>
                     <Breadcrumb.Item active>{document.getElementsByTagName('title')[0].innerText}</Breadcrumb.Item>
                  </Breadcrumb>
               </Col>
            </Row>
            <Row>
               <Col md={9}>
                  <MsgResponse {...this.state} />
                  <div className="card">
                     <div className="card-body">
                        <Form.Group className={this.state.errors.title ? 'has-danger' : ''}>
                           <Form.Control name="title" value={this.state.title} onChange={this._onChange} size="sm" autoFocus />
                           <Form.Control.Feedback type="invalid">{this.state.errors.title}</Form.Control.Feedback>
                        </Form.Group>
                        <Form.Group>
                           <Form.Control as="textarea" id="trumbowyg" />
                        </Form.Group>
                     </div>
                  </div>
               </Col>
               <Col md={3}>
                  <div className="card">
                     <div className="card-body">
                        <Form.Group className={this.state.errors.id_categories ? 'has-danger' : ''}>
                           <Form.Label>Categories</Form.Label>
                           <Form.Control name="id_categories" value={this.state.id_categories} onChange={this._onChange} size="sm" as="select">
                              <option value="">--choose--</option>
                              {content.listsCategories.map((data, key) => {
                                 return <option value={data.value} key={key}>{data.label}</option>
                              })}
                           </Form.Control>
                           <Form.Control.Feedback type="invalid">{this.state.errors.id_categories}</Form.Control.Feedback>
                        </Form.Group>
                        <Button
                           variant="success"
                           className="waves-effect waves-light"
                           size="sm"
                           onClick={this.state.btnLoading ? null : this._submit.bind(this)}
                        >{this.state.btnLoading ? 'Loading...' : 'Submit'}</Button>
                     </div>
                  </div>
               </Col>
            </Row>
         </Container>
      )
   }
}

ReactDOM.render(<Forms />, document.getElementById('root'))
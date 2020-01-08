import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Button, Form, Table } from 'react-bootstrap'
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
         price: ''
      }

      this._onChange = this._onChange.bind(this)
   }

   componentDidMount() {
      if (pageType === 'update') {
         this.setState({ ...content.detail })
      }

      this.loadData = $('#datatable').DataTable({
         responsive: true,
         ordering: true,
         processing: true,
         serverSide: true,
         ajax: {
            url: siteURL + '/usaha/profile/item/getData',
            type: 'POST'
         },
         createdRow: (row) => {
            var rows = row.cells[1].children[1].children
            var _edit = rows[0].children[0]
            var _delete = rows[1].children[0]

            _edit.onclick = () => {
               open(siteURL + '/usaha/profile/item/edit/' + _edit.dataset.id, '_parent')
            }

            _delete.onclick = () => {
               if (confirm('Are you sure you want to delete?')) {
                  this._delete(_delete.dataset.id, _delete.dataset.image)
               }
            }
         },
         columns: [
            { class: 'text-center' },
            null,
            null,
         ]
      });
   }

   _onChange(e) {
      this.setState({ [e.target.name]: e.target.value })

      if (e.target.name === 'image') {
         var input = this.image.files[0]
         var size = input.size / 1000

         if (size >= 2000) {
            this.setState({
               errors: {
                  image: 'File too large?'
               }
            })
         } else {
            this.setState({ errors: {
               image: ''
            } })
         }
      }
   }

   _delete(id, image) {
      this.setState({
         status: true,
         msg_response: 'Loading...'
      })

      var formData = new FormData()
      formData.append('pageType', 'delete')
      formData.append('id', id)
      formData.append('image', image)
      
      axios.
         post('/usaha/profile/item/delete', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })

            if (response.status) {
               this.loadData.ajax.reload(null, false)
            }
         }).
         catch(error => {
            console.log('Error', error.message)
         })
   }

   _submit() {
      this.setState({ btnLoading: true })
      var formData = new FormData()
      formData.append('pageType', pageType)
      formData.append('id', segment[5])
      formData.append('name', this.state.name)
      formData.append('image', this.image.files[0])
      formData.append('price', this.state.price)

      axios.
         post('/usaha/profile/item/submit', formData).
         then(res => {
            var response = res.data
            this.setState({ ...response })

            if (response.status) {
               this.loadData.ajax.reload(null, false)
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
                  <h4 className="text-themecolor m-b-0 m-t-0">Profile</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>Profile</Breadcrumb.Item>
                     <Breadcrumb.Item active>{document.getElementsByTagName('title')[0].innerText}</Breadcrumb.Item>
                  </Breadcrumb>
               </Col>
            </Row>
            <Row>
               <Col md={4}>
                  <div className="card">
                     <div className="card-body">
                        <Form.Group className={this.state.errors.image ? 'has-danger' : ''}>
                           <Form.Label>Image</Form.Label>
                           <Form.Control name="image" ref={e => this.image = e} onChange={this._onChange} size="sm" type="file" />
                           <Form.Control.Feedback type="invalid">{this.state.errors.image}</Form.Control.Feedback>
                           <Form.Control.Feedback type="valid">Files can only be 2MB</Form.Control.Feedback>
                        </Form.Group>
                        <Form.Group className={this.state.errors.name ? 'has-danger' : ''}>
                           <Form.Label>Item Name</Form.Label>
                           <Form.Control name="name" value={this.state.name} onChange={this._onChange} size="sm" autoFocus />
                           <Form.Control.Feedback type="invalid">{this.state.errors.name}</Form.Control.Feedback>
                        </Form.Group>
                        <Form.Group className={this.state.errors.price ? 'has-danger' : ''}>
                           <Form.Label>Price</Form.Label>
                           <Form.Control name="price" value={this.state.price} onChange={this._onChange} size="sm" type="number" />
                           <Form.Control.Feedback type="invalid">{this.state.errors.price}</Form.Control.Feedback>
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
               <Col md={8}>
                  <MsgResponse {...this.state} />
                  <div className="card">
                     <Table striped bordered hover size="sm" id="datatable">
                        <thead>
                           <tr>
                              <th>Image</th>
                              <th>Name</th>
                              <th>Price</th>
                           </tr>
                        </thead>
                     </Table>
                  </div>
               </Col>
            </Row>
         </Container>
      )
   }
}

ReactDOM.render(<Forms />, document.getElementById('root'))
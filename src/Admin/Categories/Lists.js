import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Container, Row, Col, Breadcrumb, Button, Table } from 'react-bootstrap'
import MsgResponse from '../../MsgResponse'
import axios from 'axios'

axios.defaults.baseURL = siteURL
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

export default class Lists extends Component {
   constructor() {
      super()

      this.state = {
         status: false,
         msg_response: ''
      }
   }

   componentDidMount() {
      this.loadData = $('#datatable').DataTable({
         responsive: true,
         ordering: true,
         processing: true,
         serverSide: true,
         ajax: {
            url: siteURL + '/admin/categories/getData',
            type: 'POST'
         },
         createdRow: (row) => {
            var rows = row.cells[1].children[1].children
            var _edit = rows[0].children[0]
            var _delete = rows[1].children[0]

            _edit.onclick = () => {
               open(siteURL + '/admin/categories/edit/' + _edit.dataset.id, '_parent')
            }

            _delete.onclick = () => {
               if (confirm('Are you sure you want to delete?')) {
                  this._delete(_delete.dataset.id, _delete.dataset.icon)
               }
            }
         },
         columns: [
            null,
            null,
            null,
         ]
      });
   }

   _delete(id, icon) {
      this.setState({
         status: true,
         msg_response: 'Loading...'
      })

      var formData = new FormData()
      formData.append('pageType', 'delete')
      formData.append('id', id)
      formData.append('icon', icon)
      
      axios.
         post('/admin/categories/delete', formData).
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

   render() {
      return (
         <Container fluid={true}>
            <Row className="page-titles">
               <Col md={9} className="align-self-center">
                  <h4 className="text-themecolor m-b-0 m-t-0">Categories</h4>
                  <Breadcrumb>
                     <Breadcrumb.Item active>Home</Breadcrumb.Item>
                     <Breadcrumb.Item active>{document.getElementsByTagName('title')[0].innerText}</Breadcrumb.Item>
                  </Breadcrumb>
               </Col>
               <Col md={3} className="align-self-center">
                  <Button
                     variant="success"
                     className="waves-effect waves-light float-right"
                     size="sm"
                     onClick={() => open(siteURL + '/admin/categories/addNew', '_parent')}
                  >Add New</Button>
               </Col>
            </Row>
            <Row>
               <Col md={12}>
                  <MsgResponse {...this.state} />
                  <div className="card">
                     <Table striped bordered hover size="sm" id="datatable">
                        <thead>
                           <tr>
                              <th>{' '}</th>
                              <th>Name</th>
                              <th>Modified</th>
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

ReactDOM.render(<Lists />, document.getElementById('root'))
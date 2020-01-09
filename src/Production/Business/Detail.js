import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import Header from '../Header'
import Sidebar from '../Sidebar'
import { LazyLoadImage } from 'react-lazy-load-image-component'

class Detail extends Component {
   constructor() {
      super()

      this.state = {
         openLeftSidebar: false,
         name: '',
         address: '',
         phone: '',
         email: '',
         latitude: '',
         longtitude: '',
      }
   }

   componentDidMount() {
      this.setState({ ...content.detail })
   }

   _updateState(e) {
      this.setState({ [e.name]: e.value })
   }

   render() {
      return (
         <>
            <Header _updateState={e => this._updateState(e)} {...this.state} />
            <div className="snap-drawers">
               <Sidebar _updateState={e => this._updateState(e)} {...this.state} />
               <div className="snap-content" id="content" style={{ transform: (this.state.openLeftSidebar ? 'translate3d(266px, 0px, 0px)' : ''), transition: 'all 0.3s ease 0s' }}>
                  <div className="header-clear-large" />
                  <div className="container heading-style-5">
                     <h4 className="heading-title">{this.state.name}</h4>
                     <i className="fa fa-sitemap heading-icon" />
                     <div className="line bg-black" />
                  </div>
                  <div className="blog-sidebar-recent-posts full-bottom" style={{ padding: 20 }}>
                     <div className="blog-sidebar-text">
                        <a href="#">
                           <strong><i className="fa fa-map-marker" /> Address</strong>
                           <em>{this.state.address}</em>
                        </a>
                        <a href={'tel:' + this.state.phone}>
                           <strong><i className="fa fa-phone" /> Phone</strong>
                           <em> {this.state.phone}</em>
                        </a>
                        <a href={'mailto:' + this.state.email}>
                           <strong><i className="fa fa-envelope" /> Email</strong>
                           <em>{this.state.email}</em>
                        </a>
                     </div>
                  </div>
                  <div className="container heading-style-5">
                     <h4 className="heading-title">Items</h4>
                     <i className="fa fa-sitemap heading-icon" />
                     <div className="line bg-black" />
                  </div>
                  <div className="blog-sidebar-recent-posts full-bottom" style={{ padding: 20 }}>
                     <div className="blog-sidebar-text">
                        {content.itemLists.map((data, key) => {
                           return (
                              <a href="#">
                                 <LazyLoadImage
                                    src={data.image}
                                    className="img-responsive img-thumbnail"
                                    style={{
                                       width: 60,
                                       height: 40,
                                       float: 'left',
                                       paddingRight: 20
                                    }}
                                 />
                                 <strong>{data.name}</strong>
                                 <em>{data.price}</em>
                              </a>
                           )
                        })}
                     </div>
                  </div>
                  <div className="decoration" />
                  <div className="gallery-justified">
                     {content.usahaGallery.map((data, key) => {
                        return (
                           <a href={data.path} className="show-gallery" title={data.name}>
                              <img alt={data.name} src={data.path} />
                           </a>
                        )
                     })}
                  </div>
               </div>
            </div>
         </>
      )
   }
}

ReactDOM.render(<Detail />, document.getElementById('root'))
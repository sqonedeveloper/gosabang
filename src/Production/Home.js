import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { LazyLoadImage } from 'react-lazy-load-image-component'

class Home extends Component {
   componentDidMount() {
      document.getElementsByTagName('body')[0].classList.add('no-sidebar')

      if (!content.is_login) {
         open(siteURL + '/homeLogin', '_parent')
      }
   }

   render() {
      return (
         <>
            <div className="snap-drawers">
               <div className="snap-drawer snap-drawer-left" />
               <div className="snap-drawer snap-drawer-right" />
               <div id="content" className="snap-content">
                  <div className="content">
                     <div className="thumbnail-header">
                        <a href={siteURL} className="thumbnail-logo">
                           <img src={baseURL + 'img/logo_gosabang.png'} alt="Go Sabang" />
                        </a>
                        <em>Go Sabang</em>
                     </div>
                     <div className="decoration thumbnail-decoration" />
                     <div className="thumbnail-menu">
                        {content.listsCategories.map((data, key) => {
                           return (
                              <a href={data.url}>
                                 <LazyLoadImage
                                    effect="blur"
                                    src={data.icon}
                                    className="thumbnail-icon-categories"
                                 />
                                 <em>{data.label}</em>
                              </a>
                           )
                        })}
                     </div>
                     <div className="decoration thumbnail-decoration" />
                     <div className="footer">
                        <p className="center-text">Copyright 2019. All rights reserved.</p>
                        <div className="footer-icons" style={{ textAlign: 'center' }}>
                           <a href="#" className="scale-hover facebook-color social-ball"><i className="fa fa-facebook"></i></a>
                           <a href="#" className="scale-hover twitter-color social-ball"><i className="fa fa-twitter"></i></a>
                           <a href="#" className="scale-hover google-color social-ball"><i className="fa fa-google-plus"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a href="#" className="back-to-top-badge"><i class="fa fa-caret-up" />Back to top</a>
         </>
      )
   }
}

ReactDOM.render(<Home />, document.getElementById('root'))
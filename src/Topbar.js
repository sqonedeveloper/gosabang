import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { LazyLoadImage } from 'react-lazy-load-image-component'

var sites = content.sites
var users = content.users

class Topbar extends Component {
   render() {
      return (
         <header className="topbar">
            <nav className="navbar top-navbar navbar-expand-md navbar-light">
               <div className="navbar-header">
                  <a className="navbar-brand" href={siteURL}>
                     <span style={{ fontWeight: 500, fontSize: 25 }}>
                        {sites.nama}
                     </span>
                  </a>
               </div>
               <div className="navbar-collapse">
                  <ul className="navbar-nav mr-auto mt-md-0">
                     <li className="nav-item"> <a className="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="#"><i className="mdi mdi-menu" /></a></li>
                     <li className="nav-item"> <a className="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="#"><i className="ti-menu" /></a></li>
                  </ul>
                  <ul className="navbar-nav my-lg-0">
                     <li className="nav-item dropdown">
                        <a className="nav-link dropdown-toggle text-muted waves-effect waves-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <LazyLoadImage src={baseURL + 'img/avatar.png'} effect="blur" className="profile-pic" />
                        </a>
                        <div className="dropdown-menu dropdown-menu-right scale-up">
                           <ul className="dropdown-user">
                              <li>
                                 <div className="dw-user-box">
                                    <div className="u-img">
                                       <LazyLoadImage src={baseURL + 'img/avatar.png'} effect="blur" />
                                    </div>
                                    <div className="u-text">
                                       <h4>{users.nama}</h4>
                                       <p className="text-muted">{users.email}</p>
                                    </div>
                                 </div>
                              </li>
                              <li role="separator" className="divider"></li>
                              <li><a href={siteURL + '/admin/akun/profile'}><i className="ti-user" /> My Profile</a></li>
                              <li><a href={siteURL + '/login/logout'}><i className="fa fa-power-off" /> Logout</a></li>
                           </ul>
                        </div>
                     </li>
                  </ul>
               </div>
            </nav>
         </header>
      )
   }
}

ReactDOM.render(<Topbar />, document.getElementById('header'))
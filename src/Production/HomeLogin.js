import React, { Component } from 'react'
import ReactDOM from 'react-dom'

class HomeLogin extends Component {
   render() {
      return (
         <>
            <div className="snap-drawers">
               <div id="content" className="snap-content">
                  <div className="content">
                     <div className="header-clear-large" />
                     <div className="page-login full-bottom">
                        <div className="login-input">
                           <i className="fa fa-user" />
                           <input type="text" placeholder="Username" />
                        </div>
                        <div className="login-password">
                           <i className="fa fa-lock" />
                           <input type="password" placeholder="Password" />
                        </div>
                        <div className="clear" />
                        <a className="login-button button button-small button-green button-fullscreen full-bottom">Login</a>
                        <div className="decoration" />
                        <div className="clear" />
                        <a className="facebook-login facebook-color">
                           <i className="fa fa-facebook" />{' '}Login with Facebook
                        </a>
                        <a className="google-login google-color">
                           <i className="fa fa-google-plus" />{' '}Login with Google
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </>
      )
   }
}

ReactDOM.render(<HomeLogin />, document.getElementById('root'))
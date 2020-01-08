import React, { Component } from 'react'

export default class Header extends Component {
   componentDidMount() {
      document.getElementsByTagName('body')[0].classList.add('dual-sidebar')
   }

   render() {
      return (
         <div id="header-fixed" style={{ transform: (this.props.openLeftSidebar ? 'translate3d(266px, 0px, 0px)' : ''), transition: 'all 0.3s ease 0s' }}>
            <a
               className="open-left-sidebar"
               href="#"
               onClick={() => this.props._updateState({
                  name: 'openLeftSidebar',
                  value: !this.props.openLeftSidebar
               })}
            >
               <i className="fa fa-navicon" />
            </a>
            <a className="header-logo" href={siteURL}>
               <div style={{
                  position: 'relative',
                  zIndex: 9,
                  marginLeft: 'auto',
                  marginRight: 'auto',
                  textAlign: 'center',
                  lineHeight: '55px',
                  fontSize: 30,
                  color: '#fff',
                  fontWeight: 500 }}>{this.props.name}</div>
            </a>
         </div>
      )
   }
}

import React, { Component } from 'react'

export default class Sidebar extends Component {
   render() {
      return (
         <div className="snap-drawer snap-drawer-left">
            <div className="sidebar-header">
               <a className="close-sidebar"
                  href="#"
                  onClick={() => {
                     this.props._updateState({
                        name: 'openLeftSidebar',
                        value: !this.props.openLeftSidebar
                     })
                  }}
               >
                  <i className="fa fa-times" />
               </a>
            </div>
            <div className="sidebar-menu">
               {content.listsCategories.map((data, key) => {
                  return (
                     <a className="menu-item" href={data.url} key={key}>
                        <em>{data.label}</em>
                     </a>
                  )
               })}
            </div>
         </div>
      )
   }
}

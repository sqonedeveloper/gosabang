import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import Header from './Header'
import Sidebar from './Sidebar'
import renderHTML from 'react-render-html'

class Blog extends Component {
   constructor() {
      super()

      this.state = {
         openLeftSidebar: false,
         name: '',
         content: ''
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
                     <i className="fa fa-pencil heading-icon" />
                     <div className="line bg-black" />
                  </div>
                  <div className="blog-sidebar-recent-posts full-bottom" style={{ padding: 20 }}>
                     {renderHTML(this.state.content)}
                  </div>
               </div>
            </div>
         </>
      )
   }
}

ReactDOM.render(<Blog />, document.getElementById('root'))
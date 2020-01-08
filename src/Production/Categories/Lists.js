import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { LazyLoadImage } from 'react-lazy-load-image-component'
import Header from '../Header'
import Sidebar from '../Sidebar'
import renderHTML from 'react-render-html'

class Lists extends Component {
   constructor() {
      super()

      this.state = {
         name: '',
         openLeftSidebar: false
      }
   }

   componentDidMount() {
      var detailCategories = content.detailCategories

      this.setState({
         name: detailCategories.name
      })
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
                  <div className="content" style={{ paddingLeft: 20, paddingRight: 20 }}>
                     <div className="header-clear-large" />
                     <div className="container-fullscreen" style={{ marginLeft: '-20px' }}>
                        {content.listsUsaha.length > 0 ? content.listsUsaha.map((data, key) => {
                           return (
                              <React.Fragment key={key}>
                                 <div className="one-half-responsive" onClick={() => open(data.url, '_parent')}>
                                    <p className="image-column-left">
                                       <LazyLoadImage src={data.thumbnail} />
                                       <strong>{data.name}</strong>
                                       <em>{data.string === 'text' ? data.address : renderHTML(data.address)}</em>
                                    </p>
                                 </div>
                                 <div className="decoration hide-if-responsive" />
                              </React.Fragment>
                           )
                        }) : ''}
                     </div>
                  </div>
               </div>
            </div>
         </>
      )
   }
}

ReactDOM.render(<Lists />, document.getElementById('root'))
import React, { Component } from 'react'
import ReactDOM from 'react-dom'

class Sidebar extends Component {
   constructor() {
      super()

      this.state = {
         navigation: []
      }
   }

   componentDidMount() {
      this.setState({ ...content })
   }

   render() {
      return (
         <aside className="left-sidebar">
            <div className="scroll-sidebar">
               <nav className="sidebar-nav">
                  <ul id="sidebarnav">
                     {this.state.navigation.map((data, key) => {
                        return (
                           <li key={key} className={data.active.indexOf(segment[2]) !== -1 ? 'active' : ''}>
                              <a href={siteURL + data.url} className={'waves-effect waves-dark' + (data.sub ? ' has-arrow' : '')}>
                                 <i className={data.icon} />
                                 <span className="hide-menu">{data.label}</span>
                              </a>
                              {data.sub ? <ul>{data.child.map((a, b) => {
                                 return (
                                    <li key={b} className={a.active.indexOf(segment[3]) !== -1 ? 'active' : ''}>
                                       <a href={siteURL + a.url} className={data.active.indexOf(segment[2]) !== -1 && a.active.indexOf(segment[3]) !== -1 ? 'active' : '' + (a.sub ? ' has-arrow' : '')}>{a.label}</a>
                                       {a.sub ? <ul>{a.child.map((c, d) => {
                                          return (
                                             <li key={d} className={c.active.indexOf(segment[4]) !== -1 ? 'active' : ''}>
                                                <a href={siteURL + c.url} className={c.active.indexOf(segment[4]) !== -1 ? 'active' : ''}>{c.label}</a>
                                             </li>
                                          )
                                       })}</ul> : ''}
                                    </li>
                                 )
                              })}</ul> : ''}
                           </li>
                        )
                     })}
                  </ul>
               </nav>
            </div>
         </aside>
      )
   }
}

ReactDOM.render(<Sidebar />, document.getElementById('sidebar'))
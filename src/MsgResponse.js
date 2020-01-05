import React, { Component } from 'react'

export default class MsgResponse extends Component {
   render() {
      return (
         <>
            {this.props.msg_response ? <div className={'alert' + (this.props.status ? ' alert-success' : ' alert-danger')}>{this.props.msg_response}</div> : ''}
         </>
      )
   }
}

import SignUp from './SignUp'
import React from "react";
import {render} from 'react-dom'

class SignUpElement extends HTMLElement{
    connectedCallback(){
        render(<SignUp signUp={this.dataset.signup} signIn={this.dataset.signin}/>,this)
    }
}

customElements.define('sign-up', SignUpElement)


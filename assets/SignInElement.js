import SignIn from './js/SignIn'
import React from "react";
import {render} from 'react-dom'

class SignInElement extends HTMLElement{
    connectedCallback(){
        console.log(this.dataset.signuplink)
        const linksu = this.dataset.signuplink
        const gLink = this.dataset.linkgoogle
        render(<SignIn signUp={linksu} linkGoogle={gLink}/>,this)
    }
}

customElements.define('sign-in', SignInElement)
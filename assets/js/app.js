/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// start the Stimulus application
import React, { Component } from 'react';
import ReactDOM from 'react-dom/client';
import {Header} from './header.js'
import {Footer} from "./footer.js";
import {Carousel} from "./carousel";
import {Contact} from "./contact";
import {About_us} from './about_us'
import {NavBarWithContent} from "./navbarbg";
// import { BrowserRouter } from 'react-router-dom';
// import Home from "./components/Home";

class App extends Component {
    render() {
        return (<div>
            <NavBarWithContent/>
            <Footer/>
            </div>
        )
    }
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);

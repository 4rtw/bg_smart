import React from "react";
import {Carousel} from "./js/utils/Carousel";
import {createRoot} from "react-dom/client";
import {MessageForm} from "./js/utils/MessageForm";

const contactDoc=document.getElementById('message_root')
const username=contactDoc.getAttribute("data-username")
const email=contactDoc.getAttribute("data-email")
const rootMessage=createRoot(contactDoc)
rootMessage.render(<MessageForm username={username} useremail={email}/>)

const root=createRoot(document.getElementById('carousel_contact'))
root.render(<Carousel url="/carousel/data/Contact"/>)

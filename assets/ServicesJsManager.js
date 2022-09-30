import React from "react";
import {Carousel} from "./js/utils/Carousel";
import {createRoot} from "react-dom/client";

const root=createRoot(document.getElementById('carousel_services'))
root.render(<Carousel url="/carousel/data/Services"/>)
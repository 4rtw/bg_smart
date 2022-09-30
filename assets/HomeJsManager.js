import React from "react";
import {Carousel} from "./js/utils/Carousel";
import {createRoot} from "react-dom/client";

const root=createRoot(document.getElementById('home_root'))
root.render(<Carousel url="/carousel/data/Home"/>)
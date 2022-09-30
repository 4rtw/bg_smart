import ca1 from "../../img/bgs.jpg";
import React, {useEffect, useState} from "react";
import {Text} from "./TextCarousel";



export function Images({images, texts}) {
    console.log(images)
    const [image, setImage]= useState(images[0])
    const [text, setText]= useState(texts[0])

    useEffect(()=>{
        let i= images.length-1
        const id= window.setInterval(()=>{
            setImage(images[i])
            setText(texts[i])
            i--
            if(i===-1){
                i=images.length-1
            }
            return ()=>{
                clearInterval(id)
            }
        },3000)
    },[])

    return <div className="carousel-item active">
        <img className="img-fluid" src={"uploads/images/"+image} alt="Image"/>
        <Text text={text}/>
    </div>

}
import ca1 from "../../img/bgs.jpg";
import React, {useCallback, useEffect, useState} from "react";
import {Images} from "./Images";

const  useFetchData = (url)=>{
    const [loading, setLoading]=useState(true)
    const [response, setResponse]=useState(null)
   const load= useCallback(async ()=>{
       setLoading(true)
       const res= await fetch(url,{
           method: 'GET'
       })
       const resp= await res.json()
       setResponse(resp)
       setLoading(false)
   },[url])

    return{
        loading,
        load,
        response
    }
}

export function Carousel({url}) {
    const {loading, load, response}= useFetchData(url)

    console.log( response)

    useEffect(()=>{
        load()
    },[])

    return <div className="container-fluid p-0">
        <div id="header-carousel" className="carousel slide carousel-fade" data-ride="carousel">
            <div className="carousel-inner">
                {loading ? "loading" : <Images images={response['images']} texts={response['texts']}/>}
            </div>
        </div>
    </div>
}
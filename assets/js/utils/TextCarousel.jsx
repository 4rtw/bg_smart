import React from "react";

function cleanHTML(str)
{
    if ((str===null) || (str===''))
    {
        return false;
    }
    else
    {
        str = str.toString();
        return str.replace(/<[^>]*>/g, '');
    }
}

export function Text({text}) {
    return <div className="carousel-caption d-flex align-items-center ">
        <div className="p-5" style={{width: "100%", maxWidth: "900px",backgroundColor:"rgba(250,148,42,0.5)"}}>
            <h1 className="display-3 text-white mb-md-4">{cleanHTML(text)}</h1>
        </div>
    </div>
}
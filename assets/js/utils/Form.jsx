import React from "react";

const className= (...arr)=>arr.filter(Boolean).join(' ')

export const Field=React.forwardRef(({name,help,children,error, onChange, required, minLength},ref)=>{
    if (error){
        help=error
    }
    return <div className={className('form-goup', error && 'has-error')}>
        <label htmlFor={name} className="control-label">{children}</label> <br/>
        <textarea ref={ref} id="" cols="30" rows="10" className="form-collection-item-collapse-marker"
                  name={name} id={name} required={required} minLength={minLength} onChange={onChange}/>
        {help && <div className="help-block">{help}</div>}
    </div>
})
import React, {useRef, useState} from 'react'
import axios from "axios"

export function MessageForm({username, useremail}){
    const [name,setName]=useState(username)
    const [email,setEmail]=useState(useremail)
    const [subject,setSubject]=useState('')
    const [error,setError]=useState({})
    const [status, setStatus]=useState('')
    const contentRef= useRef()
    const [loading, setLoading]=useState(false)

    const handleSubmit = async(e)=>{
        e.preventDefault()
        console.log(name)
        console.log(email)
        console.log(subject)
        console.log(contentRef.current.value)
        const data={
            sender: name,
            email: email,
            subject: subject,
            content: contentRef.current.value
        }
        setLoading(true)
        const respData= await axios.post("/api/messages", data)
        setLoading(false)

        if (!loading){
            console.log(respData)
            if(respData.status===201){
                setStatus("Your message is sent successfully!! Thanks!!!")
            }
        }

    }

    const handleNameChange=(e)=>{
        setName(e.target.value)
    }

    const handleEmailChange=(e)=>{
        setEmail(e.target.value)
    }

    const handleSubjectChange=(e)=>{
        setSubject(e.target.value)
    }

    return (
        <div className="contact-form">
            <div id="success">{status}</div>
            <form name="sentMessage" id="contactForm" noValidate="novalidate" onSubmit={handleSubmit}>
        <div className="form-row">
            <div className="col-sm-6 control-group">
                <input type="text" className="form-control p-4" id="name"
                       placeholder="Your Name" required="required" value={name}
                       data-validation-required-message="Please enter your name" onChange={handleNameChange}/>
                <p className="help-block text-danger"></p>
            </div>
            <div className="col-sm-6 control-group">
                <input type="email" className="form-control p-4" id="email"
                       placeholder="Your Email" required="required" value={email}
                       data-validation-required-message="Please enter your email" onChange={handleEmailChange}/>
                <p className="help-block text-danger"></p>
            </div>
        </div>
        <div className="control-group">
            <input type="text" className="form-control p-4" id="subject"
                   placeholder="Subject" required="required" value={subject}
                   data-validation-required-message="Please enter a subject" onChange={handleSubjectChange}/>
            <p className="help-block text-danger"></p>
        </div>
        <div className="control-group">
            <textarea className="form-control p-4" rows="6" id="message"
                      placeholder="Message" required="required" ref={contentRef}
                      data-validation-required-message="Please enter your message"></textarea>
            <p className="help-block text-danger"></p>
        </div>
        <div>
            <button className="btn btn-primary btn-block py-3 px-5" type="submit" disabled={loading}
                    id="sendMessageButton" >Send Message
            </button>
        </div>
    </form>
        </div>)
}



import React, {useRef} from 'react';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Link from '@mui/material/Link';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import {theme} from "./theme";
import {useState} from "react";


export async function jsonFecth(url,methods='POST',data=null){

    const params={
        method: methods,
        headers:{
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    }

    if (data){
        params.body=JSON.stringify(data)
    }

    const response= await fetch(url,params)
    const responseData= await response.json();
    return responseData

}

export default function SignUp(props) {
    const [loading, setLoading]= useState(false)
    const [errorData, setErrorData]=useState({errorState:false, helpError:""})
    const [reppassword, setReppassword]=useState({pwd:'',rpwd:''})

    const pwdRef=useRef('')
    const repPwdRef=useRef('')


    const handleChangePwd=()=> {
        setReppassword({
            pwd: pwdRef.current.value,
            rpwd: ''
        })
    }

    const handleChangeRPwd=()=>{
        setReppassword({
            pwd:pwdRef.current.value,
            rpwd:repPwdRef.current.value
        })

        if(reppassword.pwd!==repPwdRef.current.value) {
            setErrorData({
                errorState: true,
                helpError: "Password is not matching"
            })
        }else {
            setErrorData({
                errorState: false
            })
        }
    }



    const handleSubmit = async (event) => {
        event.preventDefault();
        const data = new FormData(event.currentTarget);

        const jsonData={
            "firstName": data.get('firstName'),
            "lastName": data.get('lastName'),
            "email": data.get('email'),
            "password": data.get('password')
        };

        console.log(jsonData)
        try{
            setLoading(true)
            const response = await jsonFecth('/api/users','POST', jsonData)
            setLoading(false)
            if (!loading){
                console.log(response)
                const successEmail=response['email']
                if(successEmail===data.get('email')){
                    window.location.href='/signup/account/successfull'
                } else {
                    console.log( response )
                }
            }
        }catch (e) {
            setLoading(false)
            window.location.href='/signup/account-exist'
        }

    };

    return (
        <ThemeProvider theme={theme}>
            <Container component="main" maxWidth="xs">
                <CssBaseline />
                <Box
                    sx={{
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                    }}
                >
                    <Typography component="h1" variant="h5">
                        Sign up
                    </Typography>
                    <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 3 }}>
                        <Grid container spacing={2}>
                            <Grid item xs={12} sm={6}>
                                <TextField
                                    autoComplete="given-name"
                                    name="firstName"
                                    required
                                    fullWidth
                                    id="firstName"
                                    label="First Name"
                                    autoFocus
                                />
                            </Grid>
                            <Grid item xs={12} sm={6}> 
                                <TextField
                                    required
                                    fullWidth
                                    id="lastName"
                                    label="Last Name"
                                    name="lastName"
                                    autoComplete="family-name"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    required
                                    fullWidth
                                    id="email"
                                    label="Email Address"
                                    name="email"
                                    autoComplete="email"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    error={errorData.errorState }
                                    helperText={errorData.helpError}
                                    onChange={handleChangePwd}
                                    inputRef={pwdRef}
                                    required
                                    fullWidth
                                    name="password"
                                    label="Password"
                                    type="password"
                                    id="password"
                                    autoComplete="new-password"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <TextField
                                    error={errorData.errorState}
                                    helperText={errorData.helpError}
                                    onChange={handleChangeRPwd}
                                    inputRef={repPwdRef}
                                    required
                                    fullWidth
                                    name="passwordRepeat"
                                    label="Repeat password"
                                    type="password"
                                    id="repeat-password"
                                    autoComplete="new-password"
                                />
                            </Grid>
                            <Grid item xs={12}>
                                <FormControlLabel
                                    control={<Checkbox value="allowExtraEmails" color="primary" />}
                                    label="I want to receive inspiration, marketing promotions and updates via email."
                                />
                            </Grid>
                        </Grid>
                        <Button
                            type="submit"
                            disabled={loading || errorData.errorState}
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                        >
                            Sign Up
                        </Button>
                        <Grid container justifyContent="flex-end">
                            <Grid item>
                                <Link href={props.signIn} variant="body2">
                                    Already have an account? Sign in
                                </Link>
                            </Grid>
                        </Grid>
                        <Button
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                            href={props.signUp}
                        >
                                SIGN UP WITH GOOGLE
                        </Button>
                    </Box>
                </Box>
            </Container>
        </ThemeProvider>
    );
}
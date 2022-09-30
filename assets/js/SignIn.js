import React, {useState} from 'react';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Link from '@mui/material/Link';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import LockOutlinedIcon from '@mui/icons-material/LockOutlined';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import {jsonFecth} from "./SignUp";
import {theme} from "./theme";
import axios from "axios";


export default function SignIn(props) {
    const [loading, setLoading]= useState({})
    const [help, setHelp]=useState('')
    const [error, setError]=useState(false)
    let respData=''

    const handleSubmit = async (event) => {

        event.preventDefault();
        const data = new FormData(event.currentTarget);

        const jsonData={
            username: data.get('email'),
            password: data.get('password')
        };

        try{
            setLoading({'post':true})
            respData= await axios.post("/api/login", jsonData)
            setLoading({'post':false})

            if(!loading.post) {
                if(respData.status===200){
                    window.location.href=respData.data.route
                }
            }


        }catch (e) {
            if(e.response){
                console.log(e.response)
                setHelp(e.response.data.error)
                setError(true)
                setLoading(false)
            }
            console.log(e)
        }

    }
    return (<ThemeProvider theme={theme}>
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
                        Sign in
                    </Typography>
                    <Box component="form" onSubmit={handleSubmit} noValidate sx={{ mt: 1 }}>
                        <TextField
                            margin="normal"
                            helperText={help}
                            error={error}
                            required
                            fullWidth
                            id="email"
                            label="Email Address"
                            name="email"
                            autoComplete="email"
                            autoFocus
                        />
                        <TextField
                            helperText={help}
                            error={error}
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="Password"
                            type="password"
                            id="password"
                            autoComplete="current-password"
                        />
                        <FormControlLabel
                            control={<Checkbox value="remember" color="primary" />}
                            label="Remember me"
                        />
                        <Button
                            type="submit"
                            disabled={loading.post}
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                        >
                            {'Log In'}
                        </Button>
                        <Grid container>
                            <Grid item xs>
                                <Link href="#" variant="body2">
                                    Forgot password?
                                </Link>
                            </Grid>
                            <Grid item>
                                <Link href={props.signUp} variant="body2">
                                    {"Don't have an account? Sign Up"}
                                </Link>
                            </Grid>
                        </Grid>
                        <Button
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                            href={props.linkGoogle}
                        >
                                {"Log in with Google account"}
                        </Button>
                    </Box>
                </Box>
            </Container>
        </ThemeProvider>);
}


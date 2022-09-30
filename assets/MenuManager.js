import * as React from 'react';
import Button from '@mui/material/Button';
import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import {createRoot} from "react-dom/client";
import {theme} from "./js/theme";
import {ThemeProvider} from "@mui/material/styles";
import Divider from "@mui/material/Divider";
import {Fragment, useEffect, useState} from "react";

function PositionedMenu({user}) {
    const [anchorEl, setAnchorEl] = React.useState(null);
    const open = Boolean(anchorEl);
    const handleClick = (event) => {
        setAnchorEl(event.currentTarget);
    };
    const handleClose=()=>{
        setAnchorEl(null);
    }

    const handleHome = () => {
        window.location.href="/"
        setAnchorEl(null);
    };

    const handleServices = () => {
        window.location.href="/services"
        setAnchorEl(null);
    };

    const handleContact = () => {
        window.location.href="/contact"
        setAnchorEl(null);
    };

    return (<ThemeProvider theme={theme}>
            <div>
                <Button
                    id="demo-positioned-button"
                    aria-controls={open ? 'demo-positioned-menu' : undefined}
                    aria-haspopup="true"
                    aria-expanded={open ? 'true' : undefined}
                    onClick={handleClick}
                >
                    Menu
                </Button>
                <Menu
                    id="demo-positioned-menu"
                    aria-labelledby="demo-positioned-button"
                    anchorEl={anchorEl}
                    open={open}
                    onClose={handleClose}
                    anchorOrigin={{
                        vertical: 'top',
                        horizontal: 'left',
                    }}
                    transformOrigin={{
                        vertical: 'top',
                        horizontal: 'left',
                    }}
                >
                    <MenuItem onClick={handleHome}>Acceuil</MenuItem>
                    <MenuItem onClick={handleServices}>Nos services</MenuItem>
                    <MenuItem onClick={handleContact}>Contact</MenuItem>
                    <ConnexionMenu user={user}/>
                </Menu>
            </div>
    </ThemeProvider>
    );
}

const ConnexionMenu= ({user})=>{
    const [connex, setConnex]=useState(<Fragment></Fragment>)

    const handleCreate=()=>{
        window.location.href="/signup"
    }

    const handleLogIn=()=>{
        window.location.href="/login"
    }

    const handleLogOut=()=>{
        window.location.href="/logout"
    }

    useEffect(()=>{
        if (user===1){
            setConnex(<Fragment>
                <Divider />
                <MenuItem onClick={handleLogOut}>Log out</MenuItem>
            </Fragment>)
        }else{
            setConnex(<Fragment>
                <Divider />
                <MenuItem onClick={handleCreate}>Create account</MenuItem>
                <MenuItem onClick={handleLogIn}>Log in</MenuItem>
            </Fragment>
                )
        }
    },[])
    return <Fragment>{connex} </Fragment>
}

const menuRoot=document.getElementById("menu_root")
const dataUser= menuRoot.getAttribute("data-user")
const root= createRoot(menuRoot)
root.render(<PositionedMenu user={parseInt(dataUser)}/>)

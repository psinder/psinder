import React from "react";
import "./App.css";
import "./RegistrationForm/RegistrationForm.js";
import RegistrationForm from "./RegistrationForm/RegistrationForm";
import AppBar from "@material-ui/core/AppBar";
import Toolbar from "@material-ui/core/Toolbar";
import Typography from "@material-ui/core/Typography";
import Container from "@material-ui/core/Container";
import List from "@material-ui/core/List";
import ListItem from "@material-ui/core/ListItem";
import ListItemText from "@material-ui/core/ListItemText";

function App() {
  return (
    <div>
      <AppBar position="static" color="default">
        <Toolbar>
          <Typography variant="h4" color="inherit">
            Psinder
          </Typography>
          <List component="nav">
            <ListItem component="div">
              <ListItemText inset>
                <Typography color="inherit" variant="h6">
                  Zwierzaki
                </Typography>
              </ListItemText>

              <ListItemText inset>
                <Typography color="inherit" variant="h6">
                  Schroniska
                </Typography>
              </ListItemText>

              <ListItemText inset>
                <Typography color="inherit" variant="h6">
                  Rejestracja
                </Typography>
              </ListItemText>
            </ListItem>
          </List>
        </Toolbar>
      </AppBar>
      <Container fixed>
        <RegistrationForm />
      </Container>
    </div>
  );
}

export default App;

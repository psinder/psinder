import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import MenuItem from "@material-ui/core/MenuItem";
import TextField from "@material-ui/core/TextField";
import InputLabel from "@material-ui/core/InputLabel";
import FormControl from "@material-ui/core/FormControl";
import Select from "@material-ui/core/Select";
import Grid from "@material-ui/core/Grid";
import DateFnsUtils from "@date-io/date-fns";
import {
  MuiPickersUtilsProvider,
  KeyboardDatePicker
} from "@material-ui/pickers";
import { Container } from "@material-ui/core";
import Button from "@material-ui/core/Button";
import Axios from "axios";

export default function AdopterRegistrationForm() {
  const [values, setValues] = React.useState({
    firstName: "",
    lastName: ""
  });

  const handleChange = name => event => {
    setValues({ ...values, [name]: event.target.value });
  };

  const submit = (event) => {
    event.preventDefault();
    const data = new FormData(event.target);

    Axios.post(
      '/register',
      {
        type: 'adopter',
        email: data.email,
        password: data.password,
        context: {
          firstName: data.firstName,
          lastName: data.lastName,
          birthdate: data.birthdate,
          gender: data.gender
        }
      }
    ).then(() => {

    }).catch(() => {

    });
  }

  return (
    <div className="row">
      <form onSubmit={submit}>
        <Container maxWidth="md">
          <Grid container>
            <Grid item xs={12}>
              <TextField
                id="first-name"
                label="Imię"
                
                onChange={handleChange("firstName")}
                fullWidth={true}
                margin="normal"
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="last-name"
                label="Nazwisko"
                
                onChange={handleChange("lastName")}
                fullWidth={true}
                margin="normal"
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="email"
                type="email"
                label="E-mail"
                
                onChange={handleChange("email")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Grid item xs={12}>
              <MuiPickersUtilsProvider utils={DateFnsUtils}>
                <KeyboardDatePicker
                  margin="normal"
                  id="birthdate"
                  label="Data urodzenia"
                  onChange={date => setValues({ ...values, birthdate: date })}
                  value={values.birthdate}
                  KeyboardButtonProps={{
                    "aria-label": "change date"
                  }}
                  fullWidth={true}
                  maxDate={new Date()}
                  format="yyyy-MM-dd" 
                />
              </MuiPickersUtilsProvider>
            </Grid>
            <Grid item xs={12} />
            <FormControl  fullWidth={true}>
              <InputLabel htmlFor="gender">Gender</InputLabel>
              <Select
                onChange={handleChange("gender")}
                inputProps={{
                  name: "gender",
                  id: "gender"
                }}
                value="male">
                <MenuItem value={"male"}>Male</MenuItem>
                <MenuItem value={"female"}>Female</MenuItem>
                <MenuItem value={"other"}>Other</MenuItem>
              </Select>
            </FormControl>
            <Button
              type="submit"
              variant="contained"
              color="primary"
            >
              Zarejestruj
            </Button>
          </Grid>
        </Container>
      </form>
    </div>
  );
}

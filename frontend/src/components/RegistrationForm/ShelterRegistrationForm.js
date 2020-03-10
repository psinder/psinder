import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import TextField from "@material-ui/core/TextField";
import Grid from "@material-ui/core/Grid";
import { Container } from "@material-ui/core";
import Button from "@material-ui/core/Button";

const useStyles = makeStyles(theme => ({
  container: {
    display: "flex",
    flexWrap: "wrap"
  },
  textField: {
    marginLeft: theme.spacing(1),
    marginRight: theme.spacing(1),
    width: 1000
  },
  dense: {
    marginTop: 19
  },
  menu: {
    width: 500
  }
}));

export default function ShelterRegistrationForm() {
  const classes = useStyles();
  const [values, setValues] = React.useState({
    firstName: "",
    lastName: ""
  });

  const handleChange = name => event => {
    setValues({ ...values, [name]: event.target.value });
  };

  const submit = () => {};

  return (
    <div className="row">
      <form className={classes.container}>
        <Container maxWidth="md">
          <Grid container>
            <Grid item xs={12}>
              <TextField
                id="name"
                label="Nazwa"
                className={classes.textField}
                onChange={handleChange("name")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="email"
                type="email"
                label="E-mail"
                className={classes.textField}
                onChange={handleChange("email")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="street"
                label="Ulica"
                className={classes.textField}
                onChange={handleChange("street")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="number"
                label="Numer"
                className={classes.textField}
                onChange={handleChange("number")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="postal-code"
                label="Kod pocztowy"
                className={classes.textField}
                onChange={handleChange("postal-code")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Grid item xs={12}>
              <TextField
                id="city"
                label="Miasto"
                className={classes.textField}
                onChange={handleChange("city")}
                margin="normal"
                fullWidth={true}
              />
            </Grid>
            <Button
              variant="contained"
              color="primary"
              className={classes.button}
              onClick={submit}
            >
              Zarejestruj
            </Button>
          </Grid>
        </Container>
      </form>
    </div>
  );
}

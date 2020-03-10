import React from "react";
import AdopterRegistrationForm from "./AdopterRegistrationForm";
import ShelterRegistrationForm from "./ShelterRegistrationForm";
import Tabs from "@material-ui/core/Tabs";
import Tab from "@material-ui/core/Tab";

export default function RegistrationForm() {
  const [accountType, setAccountType] = React.useState(0);

  return (
    <div>
      <h2>Rejestracja</h2>
      <div className="row" style={{ marginBottom: 1 + "em" }}>
      <Tabs
        value={accountType}
        onChange={(e, value) => setAccountType(value)}
        indicatorColor="primary"
        textColor="primary"
        >
        <Tab label="Adoptujący"></Tab>
        <Tab label="Schronisko" ></Tab>
    </Tabs>
        {accountType === 0 && <AdopterRegistrationForm />}
        {accountType === 1 && <ShelterRegistrationForm />}

      </div>
    </div>
  );
}

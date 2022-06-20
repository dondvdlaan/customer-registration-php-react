import { ReactElement } from "react";
import { Navigate, Route, Routes } from "react-router-dom";
import { AllJobs } from "./AllJobs";
import { JobDetails } from "./JobDetails";
import { NewJob } from "./NewJob";
import { UpdateJob } from "./UpdateJob";


import { Summary } from "./Summary";
import { Companies } from "./Companies";
import { AddCompany } from "./AddCompany";
import { UpdateComp } from "./UpdateComp";
import { CompaniesCards } from "./CompaniesCards";

export default function Routing(): ReactElement {
  return (
    <Routes>
      <Route path="/summary" element={<Summary />} />
      <Route path="/allJobs" element={<AllJobs />} />
      <Route path="/companies" element={<Companies />} />

      <Route path="/newCompany" element={<AddCompany />} />
      <Route path="/updateComp/:compID" element={<UpdateComp />} />


      <Route path="/newJob" element={<NewJob />} />
      <Route path="/updateJob/:jobID" element={<UpdateJob />} />
      <Route path="/details/:jobID" element={<JobDetails />} />

      <Route path="/" element={<Navigate to="/summary" />} />

    </Routes>
  );
}
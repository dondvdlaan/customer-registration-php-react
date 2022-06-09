import { ReactElement } from "react";
import { Navigate, Route, Routes } from "react-router-dom";
import { AllJobs } from "./AllJobs";
import { JobDetails } from "./JobDetails";
import { NewJob } from "./NewJob";
import { UpdateJob } from "./UpdateJob";


import { Summary } from "./Summary";

export default function Routing(): ReactElement {
  return (
    <Routes>
      <Route path="/summary" element={<Summary />} />
      <Route path="/allJobs" element={<AllJobs />} />
      <Route path="/newJob" element={<NewJob />} />
      <Route path="/updateJob/:jobID" element={<UpdateJob />} />


      <Route path="/details/:jobID" element={<JobDetails />} />


      <Route path="/" element={<Navigate to="/summary" />} />
    </Routes>
  );
}
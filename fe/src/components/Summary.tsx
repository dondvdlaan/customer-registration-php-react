import { useApi } from "../shared/API";
import { APPROACHED, REGISTERED } from "../shared/Constants";
import { TestModal } from "../shared/TestModal";
import { Company } from "../types/Company";
import { NewJob } from "../types/Job";


// interface Props {
//     children?: ReactElement;
//   }

export const Summary= () =>{

// Hooks and costumHooks
const [jobs, setJobs] = useApi<NewJob[]>("?action=allJobs");
const [companies, setCompanies] = useApi<Company[]>("?action=allCompanies");

if(!jobs || !companies){
  return (<p>Lade...</p>)
}

console.log("jobss: ", jobs);
console.log("companiess: ", companies);

return(
    <>
        <br />
        <h3>Summary:</h3  > 
        <div className="container">
  <div className="row text-center bg-light">
    <div className="col">
    </div>
    <div className="col">
      Total Applied
    </div>
    <div className="col">
      Pending
    </div>
    <div className="col">
      Closed
    </div>
    <div className="col">
      Won
    </div>
  </div>
  <div className="row text-center ">
    <div className="col bg-light">
      Jobs
    </div>
    <div className="col text-center     ">
        {jobs.length} 
    </div>
    <div className="col">
      {jobs.filter(job => job.jobStatus === "pending").length}
    </div>
    <div className="col">
      {jobs.filter(job => job.jobStatus === "closed").length}
    </div>
    <div className="col">
      {jobs.filter(job => job.jobStatus === "won").length}
    </div>
  </div>
  <br />
  <div className="row text-center bg-light">
    <div className="col">
    </div>
    <div className="col">
      Total
    </div>
    <div className="col">
      Registered
    </div>
    <div className="col">
      Approached
    </div>
    <div className="col">
    </div>
   </div>
   <div className="row text-center ">
    <div className="col bg-light">
      Companies  
    </div>
    <div className="col">
    {companies.length}
    </div>
    <div className="col">
    {companies.filter(company => company.compStatus === REGISTERED).length}
    </div>
    <div className="col">
    {companies.filter(company => company.compStatus === APPROACHED).length}
    </div>
    <div className="col">
      
    </div>
   </div>
</div>
        
    </>
    )
}
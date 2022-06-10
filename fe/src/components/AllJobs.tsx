import { useContext, useState } from "react";
import { useNavigate } from "react-router-dom";
import { useApi } from "../shared/API";
import { Job } from "../types/Job";
import { AppContext } from "./AppContext";
import { Pagination } from "./Pagination";


export const AllJobs = () => {
  
  // Hooks and costumHooks
  const [page, setPage] = useState(0);
  const [jobs, setJobs] = useApi<Job[]>("?action=allJobs");  
  const navigate = useNavigate();
  const maxJobsPerPage = 3;
  
  
  if(!jobs){
    return (<p>Lade...</p>)
  }
  // Event handling
  const onSetPage= (page:number) =>setPage(page);

  const totalPages = jobs.length / maxJobsPerPage;

  const jobsOnThisPage = jobs.slice(page*maxJobsPerPage,(page +1)*maxJobsPerPage)

  // Event handling
  const onGoToDetail = (job: Job) =>{
    navigate(`/details/${job.jobID}`)
  }
 
    
    return(
      <>
      <br />
      <table className="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Company</th>
      <th scope="col">Date</th>
      <th scope="col">Status</th>

    </tr>
  </thead>
  <tbody>
    {jobsOnThisPage.map(job =>
      <tr key={job.jobID} onClick={()=> onGoToDetail(job)}>
      <th scope="row">{job.jobID}</th>
      <td>{job.jobTitle}</td>
      <td>{job.jobDescription}</td>
      <td>{job.compName}</td>
      <td>{job.jobDate.slice(0, 10)}</td>
      <td>{job.jobStatus}</td>
      </tr>
      )}
    
  </tbody>
</table>
  <Pagination 
  jobs       = {jobs} 
  page       = {page} 
  totalPages = {totalPages}
  maxJobsPerPage ={maxJobsPerPage}
  onSetPage = {onSetPage}
   />
      </>
    )
}
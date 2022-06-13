import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { useApi } from "../shared/API";
import { Job } from "../types/Job";
import { Pagination } from "./Pagination";


export const AllJobs = () => {
  
  // Constants and variables
  const [page, setPage] = useState(1);
  const [jobs, setJobs] = useApi<Job[]>("?action=allJobs");  
  const navigate = useNavigate();
  const maxRowsPerPage = 3;
  
  if(!jobs){
    return (<p>Lade...</p>)
  }
  
  // Event handling
  const onGoToDetail = (job: Job) =>{
    navigate(`/details/${job.jobID}`)
  }
 
  const onSetPage= (page:number) => setPage(page);

  // Pagination
  const jobsOnThisPage = jobs.slice(( page - 1) * 
                                      maxRowsPerPage,
                                      page * maxRowsPerPage)
    
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
    {jobsOnThisPage.map((job, index) =>
      <tr key={job.jobID} onClick={()=> onGoToDetail(job)}>
      <th scope="row">{(index +1) + (page -1) * maxRowsPerPage}</th>
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
  currentPage     = {page} 
  rows            = {jobs.length}
  maxRowsPerPage  = {maxRowsPerPage}
  onSetPage       = {onSetPage}
   />
</>
    )
}
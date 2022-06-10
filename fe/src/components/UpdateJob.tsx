import { useParams } from "react-router-dom";
import { useApi } from "../shared/API";
import { Job, NewJob } from "../types/Job"
import { JobForm } from "./JobForm"



export const UpdateJob = () =>{

// Constants and Hooks
const { jobID } = useParams<{jobID: string}>();
let [job, setJob] = useApi<Job[]>(`?action=job&jobID=${jobID}`);

if(!job){return (<p>Lade...</p>)}

    return(
        <JobForm
        jobID={job[0].jobID}
        jobTitle = {job[0].jobTitle}
        jobDescription={job[0].jobDescription}
        jobDetails={job[0].jobDetails}
        jobStatus={job[0].jobStatus}
        compID={job[0].compID}
        compName={job[0].compName}
        jobDate={job[0].jobDate}

        isEdit= {true}
        />
    )
}
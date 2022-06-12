import {Method} from "axios";
import React, { useState } from "react"
import { useNavigate } from 'react-router-dom';
import { Api, useApi } from "../shared/API";
import { CLOSED, PENDING, WON } from "../shared/Constants";
import { Company } from "../types/Company";
import { NewJob, Job } from "../types/Job";

interface Props extends Job{
    isEdit: boolean
}

export const JobForm = (props: Props) =>{
    // Hooks and Constants
    const [compID, setCompID] = useState(props.compID);
    const [jobTitle, setJobTitle] = useState(props.jobTitle);
    const [jobDescription, setJobDescription] = useState(props.jobDescription);
    const [jobDetails, setJobDetails] = useState(props.jobDetails);
    const [jobStatus, setJobStatus] = useState(props.jobStatus);
    const navigate = useNavigate();
    const [companies, setCompanies] = useApi<Company[]>("?action=allCompanies");

    const postSelector = "Job";
    


    if(!companies){
        return (<p>Lade...</p>)
      }
    // const job = () =>({
    //     jobTitle,
    //     jobDescription,
    //     jobDetails,
    //     jobDate: new Date().toISOString().slice(0, 10),
    //     jobSatus: "pending",
    //     compID: compID
    // })
     const jobDataNew = {
        postSelector,
        isEdit: props.isEdit,
        jobTitle,
        jobDescription,
        jobDetails,
        jobStatus,
        compID
        }
    const jobDataUpdate = {
        postSelector,
        isEdit: props.isEdit,
        jobID: props.jobID,
        jobTitle,
        jobDescription,
        jobDetails,
        jobStatus,
        compID
        }
        
    
    console.log('New/updated Company:', compID);
    console.log('JobID:', props.jobID);
    console.log('New/updated jobTitle:', jobTitle);
    console.log('New job:', jobDataNew);
    console.log('New job:', jobDataUpdate);



    // Event handling
    const onFormSubmit = (e: React.FormEvent) =>{
        e.preventDefault();
        console.log('Form submitted');
        const [method, path, jobData]:[Method, string, {}] = props.isEdit
        ? ["post", `?action=updateJob`, jobDataUpdate]
        : ["post", `?action=newJob`, jobDataNew];

        Api(method,path, ()=>navigate('/allJobs'), jobData)
        // Api("post","newJob", ()=>navigate('/allJobs'), jobData)

    }

    return(
        <>
        <br />
    <form onSubmit={onFormSubmit}>
        <div className="form-group row">
            <label htmlFor="company" className="col-sm-2 col-form-label">Company</label>
            <div className="col-sm-10">
            <select 
            name="company" 
            className="form-control" 
            id="company" 
            placeholder="-----"
            value={compID} 
            onChange={(e)=>{setCompID(e.target.value)}}
            >
                {(props.isEdit)?
                <option value={compID}>{props.compName}</option>
                :
                <option value="" disabled selected >Select Company</option>
                }
                {companies.map(company =>
                    <option value={company.compID}>{company.compName}</option>
                )}
            </select>
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="jobTitle" className="col-sm-2 col-form-label">Job Title</label>
            <div className="col-sm-10">
            <input 
            type="text" 
            className="form-control" 
            id="jobTitle" 
            placeholder="Job Title"
            value={jobTitle}
            onChange={(e)=>{setJobTitle(e.target.value)}}
            />
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="jobDescription" className="col-sm-2 col-form-label">Job Description</label>
            <div className="col-sm-10">
            <input 
            type="text" 
            className="form-control" 
            id="jobDescription" 
            placeholder="Job Description"
            value={jobDescription}
            onChange={(e)=>{setJobDescription(e.target.value)}}
            />
            </div>
        </div>
  
        <div className="form-group row">
            <label htmlFor="jobDetails" className="col-sm-2 col-form-label">Job Details</label>
            <div className="col-sm-10">
            <input 
            type="text" 
            className="form-control" 
            id="jobDetails" 
            placeholder="Job Details"
            value={jobDetails}
            onChange={(e)=>{setJobDetails(e.target.value)}}
            />
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="jobStatus" className="col-sm-2 col-form-label">Status</label>
            <div className="col-sm-10">
            <select 
            name="jobStatus" 
            className="form-control" 
            id="jobStatus" 
            placeholder="-----"
            value={jobStatus} 
            onChange={(e)=>{setJobStatus(e.target.value)}}
            >
                <option value="" disabled selected >Status</option>
                    <option value={PENDING}>{PENDING}</option>
                    <option value={WON}>{WON}</option>
                    <option value={CLOSED}>{CLOSED}</option>
            </select>
            </div>
        </div>

        <div className="form-group row">
            <div className="col-sm-10">
            <button type="submit" className="btn btn-primary">Finished</button>
            </div>
        </div>
    </form>
    </>
    )
}
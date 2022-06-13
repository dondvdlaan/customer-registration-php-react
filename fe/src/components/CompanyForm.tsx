import {Method} from "axios";
import React, { useState } from "react"
import { useNavigate } from 'react-router-dom';
import { Api } from "../shared/API";
import { APPROACHED, CLOSED, PENDING, REGISTERED, WON } from "../shared/Constants";
import { Company } from "../types/Company";

interface Props extends Company{
    isEdit: boolean
}

export const CompanyForm = (props: Props) =>{
    // Hooks and Constants
    const [compID, setCompID] = useState(props.compID);
    const [compName, setCompName] = useState(props.compName);
    const [compType, setCompType] = useState(props.compType);
    const [compStatus, setCompStatus] = useState(props.compStatus);

    const navigate = useNavigate();
    // Selector used in PHP server to sort out POST requests
    const postSelector = "Company";

    const company = () =>({
        postSelector,
        compID,
        compName,
        compType,
        compStatus,
        isEdit: props.isEdit
    })
    
    console.log('New/updated CompID:', compID);
    console.log('New/updated compName:', compName);

    // Event handling
    const onFormSubmit = (e: React.FormEvent) =>{
        e.preventDefault();
        console.log('Form submitted');
        const [method, path]:[Method, string] = props.isEdit
        ? ["post", `updateCompany`]
        : ["post", `newCompany`];

        Api(method,path, ()=>navigate('/companies'), company())
        // Api("post","newJob", ()=>navigate('/allJobs'), jobData)

    }

    return(
        <>
        <br />
    <form onSubmit={onFormSubmit}>
        
        <div className="form-group row">
            <label htmlFor="compName" className="col-sm-2 col-form-label">Company Name</label>
            <div className="col-sm-10">
            <input 
            type="text" 
            className="form-control" 
            id="jobTitle" 
            placeholder="Company name"
            value={compName}
            onChange={(e)=>{setCompName(e.target.value)}}
            />
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="compType" className="col-sm-2 col-form-label">Company Type</label>
            <div className="col-sm-10">
            <input 
            type="text" 
            className="form-control" 
            id="compType" 
            placeholder="Company type"
            value={compType}
            onChange={(e)=>{setCompType(e.target.value)}}
            />
            </div>
        </div>
        <div className="form-group row">
            <label htmlFor="compStatus" className="col-sm-2 col-form-label">Status</label>
            <div className="col-sm-10">
            <select 
            name="compStatus" 
            className="form-control" 
            id="compStatus" 
            placeholder="-----"
            value={compStatus} 
            onChange={(e)=>{setCompStatus(e.target.value)}}
            >
                <option value="" disabled selected >Status</option>
                    <option value={REGISTERED}>{REGISTERED}</option>
                    <option value={APPROACHED}>{APPROACHED}</option>
            </select>
            </div>
        </div>

        {/* <div className="form-group row">
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
        </div> */}
  
        {/* <div className="form-group row">
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
        </div> */}

        <div className="form-group row">
            <div className="col-sm-10">
            <button type="submit" className="btn btn-primary">Finished</button>
            </div>
        </div>
    </form>
    </>
    )
}
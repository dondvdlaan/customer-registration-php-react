import React, { useState }  from "react"
import { useNavigate }      from 'react-router-dom';
import { Api, 
        ApiSimplified }     from "../../shared/API";
import { APPROACHED, 
        REGISTERED }        from "../../shared/Constants";
import { Corporation }      from "../../types/Company";
import css                  from "./CompanyForm.module.css";

interface Props extends Corporation {
    isEdit  : boolean
    
}
// Main
export const CompanyForm = (props: Props) =>{

    // *********** Hooks and Constants ***********
    const [compID]                          = useState(props.compID);
    const [compName, setCompName]           = useState(props.compName);
    const [compType, setCompType]           = useState(props.compType);
    const [compStatus, setCompStatus]       = useState(props.compStatus);
    const [emplID]                          = useState(props.emplID);
    const [emplFirstName, setEmplFirstName] = useState(props.emplFirstName);
    const [emplLastName, setEmplLastName]   = useState(props.emplLastName);
    const [emplTel, setEmplTel]             = useState(props.emplTel);
    const [emplEmail, setEmplEmail]         = useState(props.emplEmail);

    const navigate = useNavigate();

    // postSelector used in PHP server to sort out POST requests
    const postCompany = () =>({
        postSelector: "Company",
        compID,
        compName,
        compType,
        compStatus,
        isEdit: props.isEdit
    })

    const postEmployee = () =>({
        postSelector:"Employee" ,
        emplID,
        emplFirstName,
        emplLastName,
        emplTel,
        emplEmail,
        isEdit: props.isEdit
    })
    
    // *********** Event handling ***********
    const onFormSubmit = (e: React.FormEvent) =>{
        e.preventDefault();
        console.log('Form submitted');

        // Send first Employee request, then Company request to DB
        ApiSimplified("post","Employee", postEmployee())
        .then((res)=>{
          // If reply is ok, continue  
          if(res.status == 200){
            Api("post","Company", ()=>navigate('/companies'), postCompany())
          } 
          else console.log("Error",res);
        })
    }

    return(
        <>
    <form 
    className   ={css.companyForm}
    onSubmit    ={onFormSubmit}>
        <fieldset>
        <legend 
            className   ="font-weight-bold" > 
            {props.isEdit?"Update Company":"Add Company"}
        </legend>
        <div className="form-group row">
            <label htmlFor="compName" className="col-sm-3 col-form-label">Company Name</label>
            <div className="col-sm-9">
            <input 
            type        ="text" 
            className   ="form-control" 
            id          ="compName" 
            placeholder ="Company name"
            required
            value       ={compName}
            onChange    ={(e)=>{setCompName(e.target.value)}}
            />
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="compType" className="col-sm-3 col-form-label">Company Type</label>
            <div className="col-sm-9">
            <input 
            type        ="text" 
            className   ="form-control" 
            id          ="compType" 
            placeholder ="Company type"
            value       ={compType}
            onChange    ={(e)=>{setCompType(e.target.value)}}
            />
            </div>
        </div>
        <div className="form-group row">
            <label htmlFor="compStatus" className="col-sm-3 col-form-label">Status</label>
            <div className="col-sm-9">
            <select 
            name        ="compStatus" 
            className   ="form-control" 
            id          ="compStatus" 
            placeholder ="-----"
            value       ={compStatus} 
            onChange    ={(e)=>{setCompStatus(e.target.value)}}
            required
            >
                <option value="" disabled selected >Status</option>
                    <option value={REGISTERED}>{REGISTERED}</option>
                    <option value={APPROACHED}>{APPROACHED}</option>
            </select>
            </div>
        </div>

        {/* // Check if Employee has been initiated to update data, else null */}
        {(emplID != null) && (emplID != undefined) &&(
        <>
        <div className="form-group row">
            <label htmlFor="emplFirstName" className="col-sm-3 col-form-label">First name</label>
            <div className="col-sm-9">
            <input 
            type        ="text" 
            className   ="form-control" 
            id          ="emplFirstName" 
            placeholder ="First name"
            value       ={emplFirstName}
            onChange    ={(e)=>{setEmplFirstName(e.target.value)}}
            />
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="emplLastName" className="col-sm-3 col-form-label">Last Name</label>
            <div className="col-sm-9">
            <input 
            type        ="text" 
            className   ="form-control" 
            id          ="emplLastName" 
            placeholder ="Last name"
            value       ={emplLastName}
            onChange    ={(e)=>{setEmplLastName(e.target.value)}}
            />
            </div>
        </div>
        
        <div className="form-group row">
            <label htmlFor="emplTel" className="col-sm-3 col-form-label">Tel nr.</label>
            <div className="col-sm-9">
            <input 
            type        ="text" 
            className   ="form-control" 
            id          ="emplTel" 
            placeholder ="Tel nr."
            value       ={emplTel}
            onChange    ={(e)=>{setEmplTel(e.target.value)}}
            />
            </div>
        </div>

        <div className="form-group row">
            <label htmlFor="emplEmail" className="col-sm-3 col-form-label">Email</label>
            <div className="col-sm-9">
            <input 
            type        ="text" 
            className   ="form-control" 
            id          ="emplEmail" 
            placeholder ="Email"
            value       ={emplEmail}
            onChange    ={(e)=>{setEmplEmail(e.target.value)}}
            />
            </div>
        </div>
        </>
        )}
        {/* // End check Employee initiated */}

        <div className="form-group row">
            <div className="col-sm-10">
            <button type="submit" className="btn btn-primary">Finished</button>
            </div>
        </div>
        </fieldset>
    </form>
    </>
    )
}
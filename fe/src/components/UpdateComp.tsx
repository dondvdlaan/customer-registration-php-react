import { useParams } from "react-router-dom";
import { useApi } from "../shared/API";
import { Company } from "../types/Company";
import { Job, NewJob } from "../types/Job"
import { CompanyForm } from "./CompanyForm";
import { JobForm } from "./JobForm"



export const UpdateComp = () =>{

// Constants and Hooks
const { compID } = useParams<{compID: string}>();
let [company, setCompany] = useApi<Company[]>(`?action=company&compID=${compID}`);

if(!company){return (<p>Lade...</p>)}

    return(
        <CompanyForm
        compID={company[0].compID}
        compName = {company[0].compName}
        compType={company[0].compType}
        compStatus={company[0].compStatus}
        isEdit= {true}
        />
    )
}
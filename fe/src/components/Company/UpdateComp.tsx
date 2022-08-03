import { useParams }    from "react-router-dom";
import { useApi }       from "../../shared/API";
import { Corporation }  from "../../types/Company";
import { CompanyForm }  from "./CompanyForm";

/* 
*   Main function to start CompayForm to update data of individual company
*
*   @input  none
*   @return CompanyForm tsx :   CompanyForm with parameters initiated with
*                               values out of DB
*/
export const UpdateComp = () =>
{
    // Constants and Hooks
    const { compID }    = useParams<{compID: string}>();
    const [corporation] = useApi<Corporation[]>(`?action=company&compID=${compID}`);

    // Wait till data from DB arrived
    if(corporation == undefined){return (<p>Lade...</p>)}


        return(
            <CompanyForm
            compID         = {corporation[0].compID}
            compName       = {corporation[0].compName}
            compType       = {corporation[0].compType}
            compStatus     = {corporation[0].compStatus}
            emplID         = {corporation[0].emplID}
            emplFirstName  = {corporation[0].emplFirstName}
            emplLastName   = {corporation[0].emplLastName}
            emplTel        = {corporation[0].emplTel}
            emplEmail      = {corporation[0].emplEmail}
            isEdit         = {true}
            />
        )
}
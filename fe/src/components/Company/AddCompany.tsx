import { CompanyForm } from "./CompanyForm"

/* 
*   Main function to start CompayForm to add a new company
*
*   @input  none
*   @return CompanyForm tsx :   CompanyForm with parameters initiated
*/
export const AddCompany = () =>
{

    return(
        <CompanyForm
        compID          = ""
        compName        = ""
        compType        = ""
        compStatus      = ""
        emplID          = {null}
        emplFirstName   = ""
        emplLastName    = ""
        emplTel         = ""
        emplEmail       = ""
        isEdit          = {false}
        />
    )
}
import { useApi } from "../../shared/API";
import { generateRandomNumber } from "../../shared/Assistant"
import { Corporation } from "../../types/Company";
import { Companies } from "./Companies"


/*
*  Main function to call companies with employee(1 per company) from DB.
*
* @return tsx : Call component Companies
*/
export const DisplayCompany = () =>{

  // Retrieve companies from DB
  const [corporations] = useApi<Corporation[]>("?action=allCompanies");

  // Wait till company data arrived
  if (!corporations) {
    return (<p>Lade...</p>)
  }

    return(
        <Companies
        corporations  = {corporations}
        />
    )
}
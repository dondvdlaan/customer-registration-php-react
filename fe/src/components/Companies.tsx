import { useState } from "react";
import { useApi } from "../shared/API";
import { Company } from "../types/Company";
import { Pagination } from "./Pagination";



export const Companies = () => {

// Constants and variables
const [companies, setCompanies] = useApi<Company[]>("?action=allCompanies");
const [page, setPage] = useState(0);
const maxRowsPerPage = 3;

if(!companies){
    return (<p>Lade...</p>)
  }
// Event handling
const onSetPage= (page:number) =>setPage(page);

// Pagination
const totalPages = companies.length / maxRowsPerPage;
const rowsOnThisPage = companies.slice(page*maxRowsPerPage,(page +1)*maxRowsPerPage)

    
    return(
      <>
      <br />
      <table className="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Company</th>
      <th scope="col">Status</th>
      <th scope="col">Staff</th>
      <th scope="col">Tel</th>
      <th scope="col">Email</th>

    </tr>
  </thead>
  <tbody>
    {rowsOnThisPage.map(row =>
      <tr key={row.compID}>
      <th scope="row">{row.compID}</th>
      <td>{row.compName}</td>
      <td>{row.compStatus}</td>
      {/* <td>{row.jobTitle}</td>
      <td>{row.jobDescription}</td>
      <td>{row.jobDate.slice(0, 10)}</td> */}
      </tr>
      )}
    
  </tbody>
</table>
  <Pagination 
  page       = {page} 
  totalPages = {totalPages}
  maxRowsPerPage ={maxRowsPerPage}
  onSetPage = {onSetPage}
   />
      </>
    )
}
import { useState } from "react";
import Badge from 'react-bootstrap/Badge'
import { Api, useApi } from "../shared/API";
import { Company } from "../types/Company";
import { Pagination } from "./Pagination";
import {Method} from "axios";
import {  useNavigate, useParams } from 'react-router-dom';


export const Companies = () => {

// Constants and variables
const [companies, setCompanies] = useApi<Company[]>("?action=allCompanies");
const [page, setPage] = useState(0);
const navigate = useNavigate();
const maxRowsPerPage = 3;

if(!companies){
    return (<p>Lade...</p>)
  }

// Event handling
const onSetPage= (page:number) =>setPage(page);

const onUpdate = () =>{

}

const onDelete = (compID: string) =>{
  console.log('CompID', compID);
  
//Constants and variables
const method: Method = "GET";
const path: string = `?action=deleteCompany&compID=${compID}`;

Api(method,path, ()=>window.location.reload(),  {})
} 

// Pagination
const totalPages = companies.length / maxRowsPerPage;
const rowsOnThisPage = companies.slice(page*maxRowsPerPage,(page +1)*maxRowsPerPage)

    
    return(
      <>
      <br />
      <table className="table table-hover table-light">

  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Company </th>
      <th scope="col">Type</th>
      <th scope="col">Status</th>
      <th scope="col">Staff</th>
      <th scope="col">Tel</th>

    </tr>
  </thead>
  <tbody>
    {rowsOnThisPage.map(row =>
      <tr key={row.compID}>
      <th scope="row">
        {row.compID} 
        <Badge onClick={compID => onDelete(row.compID)} pill bg="warning">Del</Badge>{' '}
        <Badge pill bg="secondary">Upd</Badge>{' '}
      </th>
      <td>{row.compName} </td>
      <td>{row.compType} </td>
      <td>{row.compStatus} </td>
      
      {/* <td>{row.jobTitle}</td>
      <td>{row.jobDescription}</td>
      <td>{row.jobDate.slice(0, 10)}</td> */}
      </tr>
      )}
    
  </tbody>
</table>
  
  <br />
  <Pagination 
  currentPage     = {page} 
  totalPages      = {totalPages}
  maxRowsPerPage  = {maxRowsPerPage}
  onSetPage       = {onSetPage}
   />
      </>
    )
}
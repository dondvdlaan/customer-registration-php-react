import { useState } from "react";
import Badge from 'react-bootstrap/Badge'
import { Api, useApi } from "../shared/API";
import { Company } from "../types/Company";
import { Pagination } from "./Pagination";
import {Method} from "axios";
import {  useNavigate } from 'react-router-dom';
import { TestModal } from "../shared/TestModal";


export const Companies = () => {

// Constants and variables
const [companies, setCompanies] = useApi<Company[]>("?action=allCompanies");
const [page, setPage] = useState(1);
const navigate = useNavigate();
const maxRowsPerPage = 3;

if(!companies){
    return (<p>Lade...</p>)
  }

// Event handling
const onSetPage= (page:number) => setPage(page);

const onUpdate = (compID: string) =>{
  navigate(`/updateComp/${compID}`);
}

const onDelete = (compID: string) =>{
  //Constants and variables
  const method: Method = "GET";
  const path: string = `?action=deleteCompany&compID=${compID}`;
  // Callback to refresh page after API
  Api(method,path, ()=>window.location.reload(),  {})
} 

// Pagination
const rowsOnThisPage = companies.slice((page - 1) * maxRowsPerPage,
                                        page      * maxRowsPerPage);
    
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

    {rowsOnThisPage.map((row, index) =>
      <tr key={row.compID}>
      <th scope="row">
        {(index +1) + (page -1) * maxRowsPerPage} 
        <Badge onClick={compID => onDelete(row.compID)} pill bg="warning">Del</Badge>{' '}
        <Badge onClick={compID => onUpdate(row.compID)} pill bg="secondary">Upd</Badge>{' '}
      </th>
      <td>{row.compName} </td>
      <td>{row.compType} </td>
      <td>{row.compStatus} </td>
     
      </tr>
      )}
    
  </tbody>
</table>
  
  <br />
  <Pagination 
  currentPage     = {page} 
  rows            = {companies.length}
  maxRowsPerPage  = {maxRowsPerPage}
  onSetPage       = {onSetPage}
   />
</>
    )
}
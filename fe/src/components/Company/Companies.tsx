import { useState }     from "react";
import Badge            from 'react-bootstrap/Badge'
import { Api }          from "../../shared/API";
import { Corporation }  from "../../types/Company";
import { Pagination }   from "../Pagination";
import { Method }       from "axios";
import { useNavigate }  from 'react-router-dom';
import { useSortData }  from "../../shared/SortData";

interface Props{
  corporations: Corporation[]
}
/*
*  Main function to display all companies with employee(1 per company) from DB
*
* @input  Corporation []  : Companies and Emplees into one array
* @return tsx 
*/
export const Companies = (props:Props) => {

  // *************** Constants and variables ***************
  const [page, setPage]             = useState(1);
  const navigate                    = useNavigate();
  const {items, onSort, sortConfig} = useSortData(props.corporations);

  const maxRowsPerPage = 10;

  // *************** Event handling ***************
  const onSetPage = (page   : number) => setPage(page);

  const onUpdate  = (compID : string) => {
    navigate(`/updateComp/${compID}`);
  }

  const onDelete  = (compID : string) => {
    //Constants and variables
    const method: Method = "GET";
    const path: string = `?action=deleteCompany&compID=${compID}`;
    // Callback to refresh page after API
    Api(method, path, () => window.location.reload(), {})
  }

  // *************** Functions ***************
  // Function to check which sorting direction is chosen and which className to use
  const getClassNamesFor = (name: any) => {
    if (!sortConfig) {return;}
    return sortConfig.key === name ? sortConfig.direction : undefined;
  };

  // Pagination
  const rowsOnThisPage = items.slice((page - 1) * maxRowsPerPage,
    page * maxRowsPerPage);

  return (
    <>
      <div className="mx-0 p-0 container">
      <table className="table table-hover table-light">
      <caption>Companies</caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">
              <button 
              type="button" 
              className={getClassNamesFor("compName")?`button button1 ${getClassNamesFor("compName")}`:"button button1" } 
              onClick={() => onSort('compName')} >
                Company
              </button>
            </th>
            <th scope="col">
              <button 
              type="button" 
              className={getClassNamesFor("compType")?`button button1 ${getClassNamesFor("compType")}`:"button button1" }
              onClick={() => onSort('compType')} >
                Type
              </button>
            </th>
            <th scope="col">
              <button 
              type="button" 
              className={getClassNamesFor("compStatus")?`button button1 ${getClassNamesFor("compStatus")}`:"button button1" } 
              onClick={() => onSort('compStatus')} >
                Status
              </button>
            </th>
            <th scope="col">Staff</th>
            <th scope="col">Tel</th>

          </tr>
        </thead>
        <tbody>

          {rowsOnThisPage.map((row: Corporation, index: any) =>
            <tr key={row.compID}>
              <th scope="row">
                {/* // Numbering of rows */}
                {(index + 1) + (page - 1) * maxRowsPerPage }{' '}
                <Badge onClick={compID => onDelete(row.compID)} pill bg="warning">Del</Badge>
                <Badge onClick={compID => onUpdate(row.compID)} pill bg="secondary">Upd</Badge>{' '}
              </th>
              <td>{row.compName} </td>
              <td>{row.compType} </td>
              <td>{row.compStatus} </td>
              <td>{row.emplFirstName} {row.emplLastName} </td>
              <td>{row.emplTel}</td>
            </tr>
          )}

        </tbody>
      </table>

      <br />
      <Pagination
        currentPage     = {page}
        rows            = {props.corporations.length}
        maxRowsPerPage  = {maxRowsPerPage}
        onSetPage       = {onSetPage}
      />
    </div>
    </>
  )
}
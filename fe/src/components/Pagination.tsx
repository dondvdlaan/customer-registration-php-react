import { ReactElement, ReactNode } from "react"
import { NewJob } from "../types/Job"

interface Props{
    currentPage: number,
    rows: number,
    maxRowsPerPage: number
    onSetPage(page:number): void,
    children?: ReactNode;
}

export const Pagination = (props:Props) =>{

    // Constants and variables
    let pageNrsDisplayed = [];
    const maxPaginationDisplayed = 3;
    let previous = 1;
    let pageNrDisplayed = Math.floor((props.currentPage +1) / maxPaginationDisplayed) * maxPaginationDisplayed;
    let next = props.currentPage;
    let activePage = "page-item";

    // Calculate number of pages to display
    const totalPages = Math.ceil(props.rows / props.maxRowsPerPage);

    
    // Define previous button
    if (props.currentPage > 1) previous = props.currentPage -1;
    // Define next button   
    if (props.currentPage < totalPages) next++;

    console.log("CurrentPage: ", props.currentPage );
    console.log("TotalPages: ", totalPages );

    for (let i = 1; i <= totalPages ; i++) {
        
      // Highlight currentPage    
      activePage = ((props.currentPage) === i)? "page-item active": "page-item";

      pageNrsDisplayed.push( 
      <li 
      key={i} 
      className={activePage}>
      <button onClick={()=>props.onSetPage(i)} 
      className="page-link" >{i}
      </button></li>)
    }

    return(
<nav aria-label="Page navigation example">
  <ul className="pagination">
    <li className="page-item"><button onClick={()=>props.onSetPage(previous)} className="page-link" >Previous</button></li>
    {pageNrsDisplayed.map(pageNr=>pageNr)}
    <li className="page-item"><button onClick={()=>props.onSetPage(next)} className="page-link" >Next</button></li>
  </ul>
</nav>
    )
}
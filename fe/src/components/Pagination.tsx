import { ReactElement, ReactNode } from "react"
import { NewJob } from "../types/Job"

interface Props{
    currentPage: number,
    totalPages: number,
    maxRowsPerPage: number
    onSetPage(page:number): void,
    children?: ReactNode;
}

export const Pagination = (props:Props) =>{

    // Constants and variables
    let pageNrs = [];
    const maxNrOfPagesDisplayed = 3;
    let pageNr = 0;
    let previous = 0;
    let next = props.currentPage;
    let activePage = "page-item";

    // Define previous button
    if (props.currentPage > 0) previous = props.currentPage -1;
    // Define next button   
    if (props.currentPage < props.totalPages -1) next++;


    for (let i = 0; i < Math.min(((props.totalPages -1) - props.currentPage), maxNrOfPagesDisplayed); i++) {
        
        // After displaying the first pages, we use currentPage
        if (props.totalPages > maxNrOfPagesDisplayed) pageNr = props.currentPage;
        
        let pageNrDisplayed = pageNr + 1 + i;
        // Highlight currentPage    
        activePage = ((props.currentPage + 1) === pageNrDisplayed)? "page-item active": "page-item";

    pageNrs.push( <li key={i} className={activePage}><button onClick={()=>props.onSetPage(pageNr + i)} className="page-link" >{pageNrDisplayed}</button></li>)
    }

    return(
<nav aria-label="Page navigation example">
  <ul className="pagination">
    <li className="page-item"><button onClick={()=>props.onSetPage(previous)} className="page-link" >Previous</button></li>
    {pageNrs.map(pageNr=>pageNr)}
    <li className="page-item"><button onClick={()=>props.onSetPage(next)} className="page-link" >Next</button></li>
  </ul>
</nav>
    )
}
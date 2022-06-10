import { ReactElement, ReactNode } from "react"
import { Job } from "../types/Job"

interface Props{
    jobs:Job[],
    page: number,
    totalPages: number,
    maxJobsPerPage: number
    onSetPage(page:number): void,
    children: ReactNode;
}

export const Pagination = (props:Props) =>{

    // Constants and vairiables
    let pageNrs = [];
    const maxPagesNrDisplayed = 3;
    let pageNr = 0;
    let previous = 0;
    let next = props.page;


    if (props.page > 0) previous = props.page -1;

    if (props.page < props.totalPages -1) next++;


    for (let i = 0; i < Math.min(props.totalPages, maxPagesNrDisplayed); i++) {
        
        if (props.totalPages > maxPagesNrDisplayed) pageNr = props.page;
        
        let pageNrDisplayed = pageNr + 1 + i;

    pageNrs.push( <li key={i} className="page-item"><button onClick={()=>props.onSetPage(pageNr + i)} className="page-link" >{pageNrDisplayed}</button></li>)
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
import { ReactElement } from "react";
import { NavLink } from "react-router-dom";

interface Props {
  children: ReactElement;
}

export default function Menu(props: Props): ReactElement {

//Constants and Variables
const navLinkClassname = ({ isActive }: { isActive: boolean }) =>
    `navbar-item ${isActive ? "is-active" : ""}`;

  return (
    <>
      <nav className="navbar navbar-expand-lg navbar-light bg-light">
        <ul className="nav nav-pills" >               
          <NavLink className="nav-link" to="/summary"  >Summary </NavLink >  
          <NavLink className="nav-link" to="/allJobs"  >All Jobs </NavLink >  
          <NavLink className="nav-link" to="/companies"  >Companies </NavLink >  
          <NavLink className="nav-link" to="/newJob"  >New Job </NavLink >  
          <NavLink className="nav-link" to="/newCompany"  >Add Company </NavLink >  

        </ul>                                      
      </nav>

      <div className="container">{props.children}</div>
    </>
  );
}
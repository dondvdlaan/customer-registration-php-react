import { EmployeeForm } from "./EmployeeForm"


export const AddEmployee = () =>{


    return(
        <EmployeeForm
        emplID          = ""
        emplFirstName   = ""
        emplLastName    = ""
        emplTel         = ""
        emplEmail       = ""
        compID          = ""
        compName        = ""
        isEdit= {false}
        />
    )
}
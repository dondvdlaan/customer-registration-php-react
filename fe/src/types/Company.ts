import { Employee } from "./Employee";

interface Approached{
    approached: string;
}
interface Registered{
    registered: string;
}

export type CompStatus  = Approached | Registered;  
export type Corporation = Company & Employee;

export interface Company{
    compID        : string
    compName      : string;
    compType      : string;
    compStatus    : string;
    }


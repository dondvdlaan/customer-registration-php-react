interface Approached{
    approached: string;
}
interface Registered{
    registered: string;
}

export type CompStatus = Approached | Registered;  

export interface Company{
compID: string
compName : string;
compStatus: string;
}
interface Approached{
    approached: string;
}
interface Registered{
    registered: string;
}

export type CompStatus = Approached | Registered;  

export interface Company{
compName : string;
compStatus: CompStatus;
}
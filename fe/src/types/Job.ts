interface Registered{
    registered: string;
}
interface Pending{
    pending: string;
}
interface Closed{
    closed: string;
}
interface Won{
    won: string;
}
export type JobStatus = Registered |Pending | Closed | Won;

export interface Job extends NewJob{
readonly compID : string;
jobID           : string;    
jobDate         : string;
compName        : string;
}

export interface NewJob{
jobTitle        : string;
jobDescription  : string;
jobDetails      : string;
jobStatus       : string;
}
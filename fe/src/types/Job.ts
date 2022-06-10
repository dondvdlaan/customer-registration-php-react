interface Pending{
    pending: string;
}
interface Closed{
    closed: string;
}
interface Won{
    won: string;
}
export type JobStatus = Pending | Closed | Won;

export interface Job extends NewJob{
compID: string;
jobID: string;    
jobDate: string;
compName: string;
}

export interface NewJob{
jobTitle : string;
jobDescription: string;
jobDetails: string;
jobStatus: string;
}
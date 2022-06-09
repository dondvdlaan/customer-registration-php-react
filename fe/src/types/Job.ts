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

export interface JobWCompID extends Job{
compID: string;
}

export interface Job{
jobID: string;    
jobTitle : string;
jobDescription: string;
jobDetails: string;
jobDate: string;
jobStatus: string;
compName: string;
compID: string;

}
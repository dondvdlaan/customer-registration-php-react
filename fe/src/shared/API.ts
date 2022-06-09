import axios, { AxiosResponse, Method } from "axios";
import { Dispatch, SetStateAction, useEffect, useState } from "react";

//------------------Constanten und Typen
export const baseUrl = "http://localhost:8000/";

type SetState<T> = Dispatch<SetStateAction<T>>;

/*
 * Useful for http data as a dependency in rendering
 *
 * @param method [Method], http method
 * @param path [string], relative path to baseUrl
 * @return, Response Data
 */
export function useApi<T>(
  path: string
): [T | undefined, SetState<T | undefined>] {
  const [data, setData] = useState<T>();

  useEffect(() => {
    Api("GET", path, setData);
  }, [path]);

  return [data, setData];
}

/*
 * Useful for calls on events or in conditions
 *
 * @param method [Method], http method
 * @param path [string], relative path to baseUrl
 * @param data [function], callback, gets `response.data` as an argument
 * @param data [object], body data
 */


export function Api<T>(
    method: Method, path: string,  callback: any,
    data = {}): void {

        const config ={
            method,
            url: `${baseUrl}${path}`,
            data,
        } ;

        console.log('API config:',config);
        
        axios(config).then((response: AxiosResponse<T>) => {
            return callback(response.data);
        });
}

export function ApiSimplified<T>(method: Method, path: string, data = {}) {

      const config ={
          method,
          url: `${baseUrl}${path}`,
          data,
      } ;

      console.log('API config:',config);
      
      axios(config)
      .then((response: AxiosResponse<T>) => response.data);
      // .then((response: AxiosResponse<T>) => console.log('response.data: ', response.data));

}
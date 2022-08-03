import { Dispatch, SetStateAction, useMemo, useState } from "react";

type SetState<T> = Dispatch<SetStateAction<T>>;

/*
* Customized HOOK to sort data
*
* @param  items       : []       : Input array of data to be sorted
* @param  config      : {}       : Input object to initialise useState
* @return sortedItems : []       : Output of data sorted
* @return onSort      : function : Toggle to de destructured, as input for 
*                                  descending/ascending option)
+ @return sortConfig  : {}       : Current sort criteria
*/
export function useSortData<T>(items: T[], config = null) {

  // Constants and variables
  const [sortConfig, setSortConfig]:any = useState(config);

  // Sorting function
  const sortedItems = useMemo(() => {

    // Copy items in sortableItems to be modified
    let sortableItems = [...items];

    if (sortConfig !== null) {
      
      // Actual soring code

      sortableItems.sort((a: any, b:any) => {
        if (a[sortConfig.key] < b[sortConfig.key]) {
          return sortConfig.direction === 'ascending' ? -1 : 1;
        }
        if (a[sortConfig.key] > b[sortConfig.key]) {
          return sortConfig.direction === 'ascending' ? 1 : -1;
        }
        return 0;
      });
    }
    return sortableItems;

  }, [items, sortConfig]);

  /* Function to set direction ascending/descending based on input key
  *
  * @param key : generic : Input parameter of tuple key/value
  */
  const onSort = (key:any) => {

    let direction = 'ascending';
    
    if (
      sortConfig &&
      sortConfig.key === key &&
      sortConfig.direction === 'ascending'
    ) {
      direction = 'descending';
    }
    // Key and direction are sent to useState for subsequent sorting
    setSortConfig({ key, direction });
  };

  return { items: sortedItems, onSort, sortConfig };
};



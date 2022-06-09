import { BrowserRouter } from 'react-router-dom';
import { createContext } from 'react';
import Routing from './Routing';
import { Summary } from './Summary';
import Menu from './Menu';
import { useApi } from '../shared/API';
import { Job } from '../types/Job';
import { Company } from '../types/Company';
import { AppContext} from './AppContext';


function App() {


  return (
    <>
      <BrowserRouter>
        <Menu>
          <Routing />
        </Menu>
      </BrowserRouter>
    </>
  );
}

export default App;

 
import { Route, Routes } from 'react-router-dom';
import './App.css';  
import DefaultLayout from './components/default/DefaultLayout';
import HomePage from './components/HomePage';
import DefaultCategory from './components/default/DefaultCategory';
import AdminLayout from './components/admin/AdminLayout';
import AddCategory from './components/admin/AddCategory';

function App() {
  return (
    <>
      <Routes>
        <Route path="/" element={<DefaultLayout />}>
          <Route index element={<HomePage />} />
          <Route path="/DefaultCategory" element={<DefaultCategory />} />
        </Route>
        <Route path="/Admin/" element={<AdminLayout />}>
          <Route index element={<HomePage />} /> 
          <Route path="AddCategory" element={<AddCategory />} />
          <Route path="DefaultCategory" element={<DefaultCategory />} />
        </Route>
      </Routes>
    </>
  );
}

export default App;

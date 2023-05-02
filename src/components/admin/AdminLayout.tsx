import { Outlet } from "react-router-dom"; 
import "../default/DefaultLayout.css" 
import HeaderAdmin from "./HeaderAdmin";
const AdminLayout = () => {
    return (
        <div className="Main"> 
            <div className="container">
                <HeaderAdmin></HeaderAdmin>
                <Outlet />
            </div>
        </div>
    );
}
export default AdminLayout;

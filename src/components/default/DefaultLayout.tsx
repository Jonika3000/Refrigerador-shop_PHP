import { Outlet } from "react-router-dom";
import HeaderDefault from "./HeaderDefault";
import "./DefaultLayout.css"
const DefaultLayout = () =>
{
    return (
        <div className="Main">  

            <div className="container">
                <HeaderDefault></HeaderDefault>
                <Outlet />
            </div>
        </div>
    );
}
export default DefaultLayout;
 
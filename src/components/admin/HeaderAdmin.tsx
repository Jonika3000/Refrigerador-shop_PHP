import { Link } from "react-router-dom";
import "../default/HeaderDefault.css"
const HeaderAdmin = () => {
    return (
        <div >
            <nav className="navbar navbar-expand-lg header">
                <div className="collapse navbar-collapse mr-auto" id="navbarText">
                    <a className="Name" href="#">Refrigerador shop</a>
                </div>
                <ul className="navbar-text">
                    <li><Link to="/Admin/"><a>Home</a></Link></li>
                    <li><a>About</a></li>
                    <li><Link to="DefaultCategory"><a>Shop</a></Link></li>
                    <li><Link to="AddCategory"><a>Add Category</a></Link></li>
                </ul>
            </nav>
        </div>
    );
}
export default HeaderAdmin;
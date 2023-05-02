import { Link } from "react-router-dom";
import "./HeaderDefault.css"
import "bootstrap/dist/css/bootstrap.css";
const HeaderDefault = () =>{
    return(
        <div >
            <nav className="navbar navbar-expand-lg header">
                <div className="collapse navbar-collapse mr-auto" id="navbarText">
                    <a className="Name" href="#">Refrigerador shop</a>  
                </div>
                <ul className="navbar-text">
                    <li><Link to="/"><a>Home</a></Link></li>
                    <li><a>About</a></li>
                    <li> <Link to="/DefaultCategory"><a>Shop</a></Link></li>
                </ul>
            </nav>
        </div>
      

    );
}
export default HeaderDefault;
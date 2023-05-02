import "./HomePage.css"
import land from "../images/land.png"
import { Button, Col, Row } from 'react-bootstrap';
import { Link } from "react-router-dom";
const HomePage = () =>
{
    return(
        <div className="MainHome">
            <Row style={{ width: "100%", height: "100%" }}>
                <Col style={{ display: "flex", justifyContent: "left", alignItems: "center" }}>
                    <div style={{ display: "flex", flexDirection: "column" }}>
                        <a>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</a>
                        <Link to="/DefaultCategory">
                            <Button className="ButtonShop">
                                Shop now!
                            </Button>
                        </Link>
                    </div>
                </Col>
                <Col style={{ display: "flex", justifyContent: "center", alignItems: "center" }}>
                    <div>
                        <img src={land} style={{ width: "100%", height: "100%" }} />
                    </div>
                </Col>
            </Row>
        </div>



    );
}
export default HomePage;
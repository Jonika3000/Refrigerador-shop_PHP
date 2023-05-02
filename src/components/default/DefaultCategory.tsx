import React, { useState, useEffect } from "react";
import "./DefaultCategory.css"
import { ICategoryItem } from "../../model";
import axios from "axios";

const DefaultCategory = () => { 
    const [list, setList] = useState<ICategoryItem[]>([]);
    useEffect(() => {
        axios.get<ICategoryItem[]>("http://127.0.0.1:8000/api/category")
            .then(resp => {
                setList(resp.data);
            })
            .catch(bad => {
                console.log("Bad request", bad);
            });
    }, []);
    const dataView = list.map((category) => ( 
            <li key={category.id}><a>{category.name}</a></li> 
    ));
    return (
        <>
            <div className="MainHome">
                <div className="CenterContent">
                    <ul className="CategoryList">
                        <li style={{fontSize:"30px", cursor:"default"}}>Choose Category:</li>
                        {dataView}
                    </ul>
                </div>
            </div>
        </>
    );
}
export default DefaultCategory;

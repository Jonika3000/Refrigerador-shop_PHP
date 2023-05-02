import React, { useState } from "react";
import { Button, Form } from "react-bootstrap";
import axios from "axios";
import { ICategoryItem } from "../../model";
import { useNavigate } from "react-router-dom";

const AddCategoryForm = () => {
    const [validated, setValidated] = useState(false);
    const [category, setCategory] = useState<ICategoryItem>({
        id:0,
        name: "",
        description: "",
    });
    const navigate = useNavigate();

    const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        const form = event.currentTarget;
        event.preventDefault();
        event.stopPropagation();
        if (form.checkValidity() === false) {
            setValidated(true);
            return;
        }
        axios
            .post<ICategoryItem>("http://localhost:8000/api/category", category)
            .then((response) => {
                setCategory({ id:0,name: "", description: "" });
                navigate("/Admin/DefaultCategory");
            })
            .catch((error) => console.log(error));
    };

    const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = event.target;
        setCategory((prevState) => ({
            ...prevState,
            [name]: value,
        }));
    };

    return (
        <div className="MainHome">
            <div className="CenterContent">
                <Form noValidate validated={validated} onSubmit={handleSubmit} style={{ margin: "0 auto" }}>
                    <Form.Group className="mb-3" controlId="formCategoryName" >
                        <Form.Label style={{ color: 'white',
                    fontSize:"30px" }}>Category name</Form.Label>
                        <Form.Control 
                            type="text"
                            placeholder="Enter category name"
                            name="name"
                            value={category.name}
                            required
                            onChange={handleChange}
                        />
                        <Form.Control.Feedback type="invalid">
                            Please enter a category name.
                        </Form.Control.Feedback>
                    </Form.Group>
                    <Form.Group className="mb-3" controlId="formCategoryDescription">
                        <Form.Label style={{
                            color: 'white',
                            fontSize: "30px"
                        }}>Category description</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Enter category description"
                            name="description"
                            value={category.description}
                            required
                            onChange={handleChange}
                        />
                        <Form.Control.Feedback 
                         type="invalid">
                            Please enter a category description.
                        </Form.Control.Feedback>
                    </Form.Group>
                    <Button className="ButtonShop" style={{margin:"0"}} type="submit">Add</Button>
                </Form>
            </div>
        </div>
    );
};

export default AddCategoryForm;

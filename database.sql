CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50)
);

CREATE TABLE room01 (
    employee_id INT,
    hour TIME,
    date DATE,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

CREATE TABLE room02 (
    employee_id INT,
    hour TIME,
    date DATE,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

INSERT INTO employees (name, email, password, role) VALUES ('Romario Silva', 'romario.silva@teste.com.br', '123@123', 'Administrador');
INSERT INTO employees (name, email, password, role) VALUES ('Jerson Costa', 'jerson.costa@teste.com.br', 'senha@123', 'Desenvolvedor');
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laba2</title>
</head>
<body>
    <pre>
        <h2>Создать таблицу Employees</h2>
        CREATE TABLE Employees (
            ID SERIAL PRIMARY KEY,
            First_Name VARCHAR(50),
            Last_Name VARCHAR(50),
            Age INTEGER(3),
            Phone VARCHAR(15),
            Position VARCHAR(50),
            Salary DECIMAL(10,2)
        );

        <h2>Добавить 10 записей</h2>
        INSERT INTO Employees (First_Name, Last_Name, Age, Phone, Position, Salary)
        VALUES
            ('Ivan', 'Ivanov', 25, '123-456-7890', 'Manager', 50000.00),
            ('Peter', 'Petrov', 30, '987-654-3210', 'Programmer', 60000.00),
            ('Maria', 'Sidorova', 26, '111-222-3333', 'Analyst', 55000.00),
            ('Ivan', 'Doe', 35, '555-123-4567', 'Engineer', 70000.00),
            ('Anna', 'Smith', 28, '222-333-4444', 'Designer', 60000.00),
            ('Ivan', 'Johnson', 35, '999-888-7777', 'Manager', 65000.00),
            ('Elena', 'Kozlova', 27, '777-666-5555', 'Programmer', 62000.00),
            ('Alex', 'Brown', 40, '444-555-6666', 'Director', 80000.00),
            ('Olga', 'Popova', 29, '333-444-5555', 'Analyst', 58000.00),
            ('Robert', 'Miller', 38, '666-777-8888', 'Engineer', 72000.00);

        <h2>Вывести всех людей с одинаковым именем</h2>
        SELECT *
        FROM Employees
        WHERE First_Name IN (
            SELECT First_Name
            FROM Employees
            GROUP BY First_Name
            HAVING COUNT(*) > 1
        );

        <h2>Вывести всех людей с одинаковым именем и возрастом</h2>
        SELECT *
        FROM Employees
        WHERE (First_Name, Age) IN (
            SELECT First_Name, Age
            FROM Employees
            GROUP BY First_Name, Age
            HAVING COUNT(*) > 1
        );

        <h2>Вывести фамилию и имя тех людей у которых зарплата больше/меньше определенной</h2>
        SELECT Last_Name, First_Name
        FROM Employees
        WHERE Salary < 55000.00;

        <h2>Вывести фамилию, имя, номер телефона тех людей у которых один возраст</h2>
        SELECT Last_Name, First_Name, Phone
        FROM Employees
        WHERE Age IN (
            SELECT Age
            FROM Employees
            GROUP BY Age
            HAVING COUNT(*) > 1
        );
        
        <h2>Сделать сортировку по возрасту</h2>
        SELECT * FROM Employees ORDER BY Age;

        <h2>Сделать сортировку по зарплате</h2>
        SELECT * FROM Employees ORDER BY Salary;

        <h2>Добавить новое поле e-mail</h2>
        ALTER TABLE Employees ADD COLUMN Email VARCHAR(100);

        <h2>Добавить новое поле Организация</h2>
        ALTER TABLE Employees ADD COLUMN Organization VARCHAR(100);

        <h2>Заполнить новые поля</h2>
        UPDATE Employees
        SET
        Email = CASE
            WHEN ID = 1 THEN 'ivan.ivanov@example.com'
            WHEN ID = 2 THEN 'peter.petrov@example.com'
            WHEN ID = 3 THEN 'maria.sidorova@example.com'
            WHEN ID = 4 THEN 'ivan.doe@example.com'
            WHEN ID = 5 THEN 'anna.smith@example.com'
            WHEN ID = 6 THEN 'ivan.johnson@example.com'
            WHEN ID = 7 THEN 'elena.kozlova@example.com'
            WHEN ID = 8 THEN 'alex.brown@example.com'
            WHEN ID = 9 THEN 'olga.popova@example.com'
            WHEN ID = 10 THEN 'robert.miller@example.com'
            ELSE Email
        END,
        Organization = CASE
            WHEN ID = 1 THEN 'Company A'
            WHEN ID = 2 THEN 'Company B'
            WHEN ID = 3 THEN 'Company A'
            WHEN ID = 4 THEN 'Company B'
            WHEN ID = 5 THEN 'Company C'
            WHEN ID = 6 THEN 'Company A'
            WHEN ID = 7 THEN 'Company B'
            WHEN ID = 8 THEN 'Company C'
            WHEN ID = 9 THEN 'Company A'
            WHEN ID = 10 THEN 'Company C'
            ELSE Organization
        END;
    </pre>
</body>
</html>

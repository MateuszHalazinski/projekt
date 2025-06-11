-- Tabela użytkownicy
CREATE TABLE uzytkownicy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    haslo VARCHAR(255) NOT NULL,
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    rola ENUM('admin', 'uczen', 'nauczyciel') NOT NULL
);

-- Tabela oceny
CREATE TABLE oceny (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ucznia INT NOT NULL,
    ocena DECIMAL(3,1) NOT NULL, -- np. 4.5
    przedmiot VARCHAR(100) NOT NULL,
    komentarz TEXT,
    FOREIGN KEY (id_ucznia) REFERENCES uzytkownicy(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

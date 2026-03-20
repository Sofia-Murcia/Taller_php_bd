<?php
// CONECTION TO DATA BASE
// 1. DATOS DE CONEXIÓN
// Variables con la información para conectarse a MySQL
$host     = "localhost";   // Servidor donde está MySQL
$usuario  = "root";        // Usuario de MySQL
$password = "";            // Contraseña de MySQL
$base     = "colegio";     // Nombre de la base de datos

// 2. CONECTAR A MYSQL
// mysqli_connect intenta abrir la conexión. Si falla, se muestra el error y se detiene el programa

$conexion = mysqli_connect($host, $usuario, $password);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// 3. CREAR BASE DE DATOS Y SELECCIONARLA

mysqli_query($conexion, "CREATE DATABASE IF NOT EXISTS $base"); // Crea la base de datos si no existe

mysqli_select_db($conexion, $base); // Selecciona la base de datos para trabajar

echo "Base de datos lista <br><br>";

// 4. CREAR TABLAS: Se crean tablas separadas según la normalización

// TABLA ALUMNO
mysqli_query($conexion, "
CREATE TABLE IF NOT EXISTS alumno (
    idAlumno INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    idEspecialidad INT,
    idCodigoAlumno INT
)
");

// TABLA DOCENTE
mysqli_query($conexion, "
CREATE TABLE IF NOT EXISTS docente (
    idDocente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    idOficina INT
)
");

// TABLA CURSOS
mysqli_query($conexion, "
CREATE TABLE IF NOT EXISTS cursos (
    idCurso INT AUTO_INCREMENT PRIMARY KEY,
    codigoCurso VARCHAR(20),
    idDocente INT
)
");

// TABLA SALON
mysqli_query($conexion, "
CREATE TABLE IF NOT EXISTS salon (
    idSalon INT AUTO_INCREMENT PRIMARY KEY,
    salon VARCHAR(5)
)
");

echo "Tablas creadas <br><br>";

// 5. INSERTAR DATOS: Se insertan los datos que aparecen en tu tabla

// ALUMNOS
mysqli_query($conexion, "INSERT INTO alumno (nombre, apellido, idEspecialidad, idCodigoAlumno)
VALUES ('Luis', 'Zuloaga', 21, 81)");

mysqli_query($conexion, "INSERT INTO alumno (nombre, apellido, idEspecialidad, idCodigoAlumno)
VALUES ('Raul', 'Rojas', 22, 82)");


// DOCENTES
mysqli_query($conexion, "INSERT INTO docente (nombre, apellido, idOficina)
VALUES ('Carlos', 'Arambulo', 41)");

mysqli_query($conexion, "INSERT INTO docente (nombre, apellido, idOficina)
VALUES ('Petra', 'Rondinal', 42)");

mysqli_query($conexion, "INSERT INTO docente (nombre, apellido, idOficina)
VALUES ('Victor', 'Mancada', 43)");

mysqli_query($conexion, "INSERT INTO docente (nombre, apellido, idOficina)
VALUES ('Cesar', 'Fernandez', 44)");


// CURSOS
mysqli_query($conexion, "INSERT INTO cursos (codigoCurso, idDocente)
VALUES ('MA123', 1)");

mysqli_query($conexion, "INSERT INTO cursos (codigoCurso, idDocente)
VALUES ('QU514', 2)");

mysqli_query($conexion, "INSERT INTO cursos (codigoCurso, idDocente)
VALUES ('AU521', 3)");

mysqli_query($conexion, "INSERT INTO cursos (codigoCurso, idDocente)
VALUES ('PA714', 4)");

mysqli_query($conexion, "INSERT INTO cursos (codigoCurso, idDocente)
VALUES ('AU511', 3)");


// SALONES
mysqli_query($conexion, "INSERT INTO salon (salon)
VALUES ('U'), ('W'), ('V')");

echo "Datos insertados <br><br>";

// 6. CONSULTA (JOIN): Une varias tablas para mostrar información completa

$sql = "
SELECT 
    alumno.nombre AS nombreAlumno,
    alumno.apellido AS apellidoAlumno,
    cursos.codigoCurso,
    docente.nombre AS nombreDocente,
    docente.apellido AS apellidoDocente
FROM alumno
INNER JOIN cursos ON alumno.idAlumno = cursos.idCurso
INNER JOIN docente ON cursos.idDocente = docente.idDocente
";

$resultado = mysqli_query($conexion, $sql); // Ejecuta la consulta

echo "<h3>Consulta general:</h3>"; // Recorre los resultados

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "Alumno: " . $fila['nombreAlumno'] . " " . $fila['apellidoAlumno'] . " | ";
    echo "Curso: " . $fila['codigoCurso'] . " | ";
    echo "Docente: " . $fila['nombreDocente'] . " " . $fila['apellidoDocente'];
    echo "<br>";
}

// 7. CERRAR CONEXIÓN

mysqli_close($conexion); // Libera recursos y cierra la conexión

echo "<br>Conexión cerrada";
?>
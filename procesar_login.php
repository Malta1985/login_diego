<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4">Iniciar Sesión</h1>
                        <!-- Mensajes de éxito o error -->
                        <?php
                        // Verificar si se han enviado datos
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Recibir datos del formulario
                            $email = $_POST["email"];
                            $contrasena = $_POST["contrasena"];

                            // Conectar a la base de datos
                            $servername = "localhost";
                            $username = "root";
                            $password = "Malta12345$";
                            $dbname = "login_diego";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Verificar la conexión
                            if ($conn->connect_error) {
                                echo '<div class="alert alert-danger" role="alert">Error de conexión: ' . $conn->connect_error . '</div>';
                            } else {
                                // Consulta SQL para verificar las credenciales
                                $sql = "SELECT * FROM datos WHERE email = ? AND contrasena = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("ss", $email, $contrasena);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Verificar si se encontró un usuario con las credenciales proporcionadas
                                if ($result->num_rows == 1) {
                                    echo '<div class="alert alert-success" role="alert">Acceso correcto</div>';
                                } elseif ($result->num_rows == 0) {
                                    echo '<div class="alert alert-danger" role="alert">Usuario incorrecto en email o contraseña</div>';
                                }

                                // Cerrar la conexión
                                $stmt->close();
                                $conn->close();
                            }
                        }
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                            </div>
                            <div class="text-center">
                                <a href="#" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Enlace al script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

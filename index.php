<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Números Aleatorios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f2f5;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .checkbox {
            margin: 15px 0;
        }

        .checkbox label {
            display: inline;
            margin-left: 5px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .resultado {
            margin-top: 20px;
        }

        .numeros-lista {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .numeros-lista li {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #e9ecef;
            min-width: 60px;
        }

        .error {
            color: #dc3545;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
            }
            .numeros-lista {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generador de Números Aleatorios</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="desde">Número Inicial:</label>
                <input type="number" id="desde" name="desde" required 
                       value="<?php echo isset($_POST['desde']) ? htmlspecialchars($_POST['desde']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="hasta">Número Final:</label>
                <input type="number" id="hasta" name="hasta" required
                       value="<?php echo isset($_POST['hasta']) ? htmlspecialchars($_POST['hasta']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad de números a generar:</label>
                <input type="number" id="cantidad" name="cantidad" required min="1" max="100"
                       value="<?php echo isset($_POST['cantidad']) ? htmlspecialchars($_POST['cantidad']) : '10'; ?>">
            </div>

            <div class="checkbox">
                <input type="checkbox" id="permitir_repetidos" name="permitir_repetidos" 
                       <?php echo isset($_POST['permitir_repetidos']) ? 'checked' : ''; ?>>
                <label for="permitir_repetidos">Permitir números repetidos</label>
            </div>

            <button type="submit" name="generar">Generar Números</button>
        </form>

        <div class="resultado">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generar'])) {
                $desde = intval($_POST['desde']);
                $hasta = intval($_POST['hasta']);
                $cantidad = intval($_POST['cantidad']);
                $permitir_repetidos = isset($_POST['permitir_repetidos']);

                // Validación de entrada
                if ($desde >= $hasta) {
                    echo "<p class='error'>Error: El número inicial debe ser menor que el número final.</p>";
                } else if ($cantidad < 1 || $cantidad > 100) {
                    echo "<p class='error'>Error: La cantidad debe estar entre 1 y 100.</p>";
                } else {
                    $numeros = array();
                    $rango = $hasta - $desde + 1;

                    if ($permitir_repetidos) {
                        // Generar números aleatorios con posibilidad de repetición
                        for ($i = 0; $i < $cantidad; $i++) {
                            $numeros[] = rand($desde, $hasta);
                        }
                    } else {
                        // Generar números únicos
                        if ($rango < $cantidad) {
                            echo "<p class='error'>Error: No hay suficientes números únicos en el rango especificado para generar $cantidad números diferentes.</p>";
                        } else {
                            // Crear array con todos los números del rango
                            $todos_numeros = range($desde, $hasta);
                            // Mezclar array
                            shuffle($todos_numeros);
                            // Tomar los primeros N números
                            $numeros = array_slice($todos_numeros, 0, $cantidad);
                            sort($numeros); // Ordenar para mejor visualización
                        }
                    }

                    if (!empty($numeros)) {
                        echo "<h2>Números generados:</h2>";
                        echo "<ul class='numeros-lista'>";
                        foreach ($numeros as $numero) {
                            echo "<li>$numero</li>";
                        }
                        echo "</ul>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

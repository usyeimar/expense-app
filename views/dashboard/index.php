<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense App</title>
</head>
<body>
    <?php require 'header.php'; ?>

    <div id="main-container">
            
        <div id="expenses-container">

            <div id="left-container">
                <div id="expenses-summary">
                    <div class="card w-50">
                        <div class="total-expense">
                            $5,698.00
                        </div>
                        <div class="total-budget">
                            de <span class="total-budget-text">$6,700.00</span>
                        </div>
                    </div>
                    <div class="card w-50">
                        <form action="expenses/newExpense" method="POST">
                        Descripcion
                        <input type="text" name="title">
                        Cantidad
                        <input type="text" name="amount">
                        Categoria
                        <select name="category" id="">
                            <option value="1">comida</option>
                            <option value="2">hogar</option>
                            <option value="3">ropa</option>
                        </select>
                        <input type="submit" value="Nuevo expense">
                        </form>
                    </div>
                </div>

                <div id="expenses-category">
                    <h3>Categories</h3>
                    <div id="categories-container">
                        <div class="card ws-30">
                            Hogar
                        </div>
                        <div class="card ws-30">
                            Ropa
                        </div>
                        <div class="card ws-30">
                            Comida
                        </div>
                        <div class="card ws-30">
                            Ocio
                        </div>
                        <div class="card ws-30">
                            Hogar
                        </div>
                    </div>
                </div>
            </div>

            <div id="right-container">
                <div id="expenses-transactions">
                    <h3>últimas transacciones</h3>
                </div>
            </div>
            

        </div>

    </div>

    <?php require 'views/footer.php'; ?>
</body>
</html>
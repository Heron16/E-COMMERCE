<?php include 'templates/header.php'; ?>

<div class="content">
    <h1>Login</h1>
    
    <form method="POST" action="?route=login">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Entrar">
        </div>
    </form>
    
    <p>Não tem conta? <a href="?route=cadastro">Cadastre-se aqui</a></p>
    
    <p><strong>Dados para teste (Admin):</strong></p>
    <p>Email: admin@lavacar.com<br>Senha: admin123</p>
</div>

<?php include 'templates/footer.php'; ?>


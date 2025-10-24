<?php include 'templates/header.php'; ?>

<div class="content">
    <h1>Cadastro</h1>
    
    <form method="POST" action="?route=cadastro">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        
        <div class="form-group">
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
    
    <p>Já tem conta? <a href="?route=login">Faça login aqui</a></p>
</div>

<?php include 'templates/footer.php'; ?>


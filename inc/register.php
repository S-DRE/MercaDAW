<div class="container">
    <form class = "text-center border border-light p-5" action="/crud.php?op=1" method="post">
        <p class = "h4 mb-4">Registro de usuarios</p>
        <div class = "form-row mb-4">
            <div class = "col">
                <input type = "text" id = "nombre" name = "nombre" class = "form-control" placeholder = "nombre" maxlength = "30" required>
            </div>
            <div class = "col">
                <input type = "text" id = "apellidos" name = "apellidos" class = "form-control" placeholder = "nombre" maxlength = "30" required>
            </div>
            <br><br/>
            <div class = "col">
                <input type = "text" id = "nick" name = "nick" class = "form-control" placeholder = "Nick or Username" maxlength = "30" required>
            </div>
            <br><br/>
            <div class="col">
                <input type="text" id="email" name="email" class="form-control" placeholder="email" maxlength="30" required>
            </div>
            <div class="col">
                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" maxlength="50" required>
            </div>
        </div>
        <button class="btn btn-info my-4 btn-block" type="submit">Log In</button>
    </form>
</div>
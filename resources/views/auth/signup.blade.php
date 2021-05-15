<form action="register" method="post">
    @csrf

    @error('message')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <input type="name" name="name" placeholder="Nome"/>
    <input type="email" name="email" placeholder="Email"/>
    <input type="password" name="password" placeholder="Senha"/>
    <input type="submit" value="CADASTRAR"/>
</form>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Inicio de Sesión</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" id='login-form'>
                            @csrf
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Recordar Contraseña</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </form>
                        <div class="mt-3">
                            <a href="{{ route('register') }}">¿Ya tienes una cuenta? Registrate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let remember = document.getElementById('remember').checked;

            axios.post('{{ route('login') }}', {
                email: email,
                password: password,
                remember: remember
            })
            .then(response => {
                console.log(response);
                localStorage.setItem('token', response.data.access_token);
                window.location.href = '/';
                //window.location.href = '?token=' + token;
            })
            .catch(error => {
                console.error(error);
                if (error.response && error.response.data) {
                    let errors = error.response.data.errors;
                    document.getElementById('email-error').textContent = errors.email ? errors.email[0] : '';
                    document.getElementById('password-error').textContent = errors.password ? errors.password[0] : '';
                }
            });
        });
    </script>
</body>
</html>

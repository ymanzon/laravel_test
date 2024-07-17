<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <h5 id="welcome-message" class="card-title">Cargando...</h5>
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
        
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('/')
                .then(response => {
                    console.log(response.data);
                    //document.getElementById('welcome-message').textContent = response.data;
                    //document.getElementById('welcome-message').innerHTML(response.data);
                    //$('#welcome-message').html(respone.data);
                    $('#welcome-message').html(response.data);
                })
                .catch(error => {
                    console.error(error);
                    //document.getElementById('welcome-message').textContent = 'Error al cargar el mensaje de bienvenida.';
                    //console.error(error);
                    //if (error.response.status === 401) {
                    //    window.location.href = '/login';
                   // }
                });

        });
        
    </script>
</body>
</html>

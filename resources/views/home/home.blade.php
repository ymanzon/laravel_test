<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Lista de Usuarios</h1>
                <!--form id="createForm" action="" method="get" target="_blank">
                    <button type="submit"id="addUser" class="btn btn-primary mb-3">Agregar Nuevo Usuario</button>
                </form-->
                <!-- Filtro de Búsqueda -->
                <div class="mb-3">
                    <!--input type="text" id="searchId" placeholder="Buscar por ID" class="form-control mb-2"-->
                    <input type="text" id="searchName" placeholder="Buscar por Nombre" class="form-control mb-2">
                    <input type="text" id="searchEmail" placeholder="Buscar por Email" class="form-control mb-2">
                    <input type="date" id="searchCreatedAt" placeholder="Buscar por Fecha de creación" class="form-control mb-2">
                    <input type="date" id="searchUpdatedAt" placeholder="Buscar por Fecha de Edición" class="form-control mb-2">
                    <button id="searchButton" class="btn btn-secondary">Buscar</button>
                    <!--button id="resetButton" class="btn btn-secondary">limpiar campos</button-->
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Creación</th>
                            <th>Actualización</th>
                            <th>Activo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

     <!-- Modal de Edición -->
     <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="editUserId">
                        <div class="form-group">
                            <label for="editUserName">Nombre</label>
                            <input type="text" class="form-control" id="editUserName" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserEmail">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="editUserActive">Activo</label>
                            <select class="form-control" id="editUserActive">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas cambiar el estado del usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>


        $(document).ready(function() {

            $("#searchButton").on("click",function (){
                readySearch();
            });

            document.getElementById('confirmButton').addEventListener('click', function () {

                deactivateUser(selectedUserId);
                
            });

            

            readySearch();

        });
            
       function readySearch(){
            const token = localStorage.getItem('token');
            $.ajaxSetup({
            headers:{
                'Authorization': "Bearer " + token
            }
            });

            let filter = "";

            if($('#searchName').val() != ''){
                filter += `name=${$('#searchName').val()}`;
            }

            if($('#searchEmail').val() != ''){
                filter += `email=${$('#searchEmail').val()}`;
            }

            if($('#searchCreatedAt').val() != ''){
                filter += `created_at=${$('#searchCreatedAt').val()}`;
            }

            if($('#searchUpdatedAt').val() != ''){
                filter += `updated_at=${$('#searchUpdatedAt').val()}`;
            }

            let path =`/user/retrive?${filter}`;

            $.get( path, function(response) {
                    /////
                    //let form = document.getElementById('createForm');
                    //form.action = response.create;
                    
                    let users = response.data;
                            let tableBody = document.getElementById('userTableBody');
                            tableBody.innerHTML = '';

                            users.forEach(user => {
                                let row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${formatDate(user.created_at)}</td>
                                    <td>${formatDate(user.updated_at)}</td>
                                    <td>${user.active ? 'Sí' : 'No'}</td>
                                    <td>
                                        <button class="btn btn-warning" onclick="showEditModal(${user.id})">Actualizar</button>
                                        <button class="btn btn-danger" onclick="deleteUser(${user.id})">Eliminar</button>
                                        <button class="btn btn-secondary" onclick="showConfirmModal(${user.id})"> ${user.active?'Desactivar':'Activar'} </button>
                                    </td>
                                `;
                                tableBody.appendChild(row);
                });

                function formatDate(dateString) {
                    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                    const date = new Date(dateString);
                    return date.toLocaleDateString('es-ES', options);
                }


                window.showEditModal = function (id) {
                fetch(`/user/${id}`,{
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                            'Authorization': "Bearer " + token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const user = data.data;
                        document.getElementById('editUserId').value = user.id;
                        document.getElementById('editUserName').value = user.name;
                        document.getElementById('editUserEmail').value = user.email;
                        document.getElementById('editUserActive').value = user.active ? 1 : 0;

                        $('#editModal').modal('show');
                    });
            }

            ///EditAction
            document.getElementById('editUserForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const userId = document.getElementById('editUserId').value;
                const userName = document.getElementById('editUserName').value;
                const userEmail = document.getElementById('editUserEmail').value;
                const userActive = document.getElementById('editUserActive').value;

                fetch(`/user/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': "Bearer " + token
                    },
                    body: JSON.stringify({
                        name: userName,
                        email: userEmail,
                        active: userActive == 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    $('#editModal').modal('hide');
                    readySearch();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al actualizar el usuario.');
                });
            });


            //
            window.updateUser = function(id) {
                console.log(id);
            }

            window.deleteUser = function(id) {
                const token = localStorage.getItem('token');
                
                fetch(`/user/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': "Bearer " + token
                    }
                })
                .then(response => response.json())
                .then(data => {
                    //alert(data.message);
                    $('#confirmModal').modal('hide');
                    readySearch();
                })
                .catch(error => {
                    console.log(error);
                    //console.error('Error:', error);
                    //alert('Hubo un error al desactivar el usuario.');
                });
            }

            window.showConfirmModal = function (id, action) {
                selectedUserId = id;
                selectedAction = action;
                $('#confirmModal').modal('show');
            }

            

            window.deactivateUser = function (id) {
                const token = localStorage.getItem('token');
                
                fetch(`/user/deactivate/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': "Bearer " + token
                    }
                })
                .then(response => response.json())
                .then(data => {
                    //alert(data.message);
                    $('#confirmModal').modal('hide');
                    readySearch();
                })
                .catch(error => {
                    console.log(error);
                    //console.error('Error:', error);
                    //alert('Hubo un error al desactivar el usuario.');
                });
            }


            $('#addUser').on('click', function() {
                // Implementar lógica para agregar nuevo usuario
                alert('Agregar nuevo usuario');
            });
                /////
            }).fail(function(jqxhr) {
                console.log(jqxhr);
                $('#welcome-message').text('Error al cargar el mensaje de bienvenida.');
                if (jqxhr.status === 401) {
                    window.location.href = '/login';
                }
                });

        }
        
    </script>
</body>
</html>

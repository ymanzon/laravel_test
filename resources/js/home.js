// home.js
$(document).ready(function() {
    const token = localStorage.getItem('token');

    if (!token) {
        // Redirige a la página de login si no hay token
        //window.location.href = '/login.html';
        console.error("token not found");
    } else {
        $.ajax({
            url: '/',  // Cambia esta URL a tu endpoint de home si es necesario
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            success: function(response) {
                $('#message').text(response.message);  // Muestra el mensaje en la página de home
            },
            error: function(error) {
                console.error('Error fetching home data:', error);
                alert('Failed to load home content, please try again.');
                // Redirige a la página de login en caso de error
                //window.location.href = '/login.html';
            }
        });
    }
});

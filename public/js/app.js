// Configurar Axios para enviar el token en cada petición
axios.interceptors.request.use(
    function(config) {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    },
    function(error) {
        return Promise.reject(error);
    }
);

// Redirigir al usuario al login si no está autenticado
axios.interceptors.response.use(
    function(response) {
        return response;
    },
    function(error) {
        if (error.response.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);


/*
// Configurar jQuery para enviar el token en cada petición
$(document).ajaxSend(function(event, jqxhr, settings) {
    const token = localStorage.getItem('token');
    if (token) {
        jqxhr.setRequestHeader('Authorization', 'Bearer ' + token);
    }
});

// Redirigir al usuario al login si no está autenticado
$(document).ajaxError(function(event, jqxhr, settings, thrownError) {
    if (jqxhr.status === 401) {
        localStorage.removeItem('token');
        window.location.href = '/login';
    }
});
*/
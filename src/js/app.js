let paso = 1;
let pasoInicial = 1;
let pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {

    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); //muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presionan los tabs
    botonesPaginador(); //agrega o quita los botones del paginador
    paginaAnterior();
    paginaSiguiente();
    consultarApi(); // consulta la API en el backend de php
    idCliente();
    nombreCliente(); //anade el nombre del cliente al objeto de cita
    seleccionarFecha(); //anade la fecha al objeto de cita
    seleccionarHora(); //anade la hora al objeto de cita

    mostrarResumen();

}

function mostrarSeccion() {

    //ocultar la seccion que tenga la clase mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
   
    // seleccionar la seccion con el paso
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    //quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }


    //resalta el color del tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach( boton => {
        boton.addEventListener('click', function(e) {
            
            e.preventDefault();
            paso = parseInt( e.target.dataset.paso );
            mostrarSeccion();
            botonesPaginador();
           
        });
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if( paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {

       if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {

       if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}

async function consultarApi() {
    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
   } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach( servicio => {
        const { id, nombre, precio } = servicio;
            const nombreServicio = document.createElement('P');
            nombreServicio.classList.add('nombre-servicio');
            nombreServicio.textContent = nombre;
            const precioServicio = document.createElement('P');
            precioServicio.classList.add('precio-servicio');
            precioServicio.textContent = `$${precio}`;

            const servicioDiv = document.createElement('DIV');
            servicioDiv.classList.add('servicio');
            servicioDiv.dataset.idServicio = id;
            servicioDiv.onclick = function() {
                seleccionarServicio(servicio);
            }

            servicioDiv.appendChild(nombreServicio);
            servicioDiv.appendChild(precioServicio);

            document.querySelector('#servicios').appendChild(servicioDiv);
    })
}

    function seleccionarServicio(servicio){
        const { id } = servicio;
        const { servicios } = cita;

        //identificar al elemento que se la click
        const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

        //comprobar si un servicio ya fue agregado 
        if( servicios.some( agregado => agregado.id === id ) ) {
                // eliminar
                cita.servicios = servicios.filter( agregado => agregado.id !== id );
                divServicio.classList.remove('seleccionado');
        } else {
                //agregarlo
                cita.servicios = [...servicios, servicio];
                divServicio.classList.add('seleccionado');
        }
     }

     function idCliente() {
        cita.id = document.querySelector('#id').value;
     }

     function nombreCliente() {
        cita.nombre = document.querySelector('#nombre').value;
     }

     function seleccionarFecha() {
        const inputFecha = document.querySelector('#fecha');
        inputFecha.addEventListener('input', function(e) {
           
            const dia = new Date(e.target.value).getUTCDay();
           
            if( [6, 0].includes(dia) ) {
                e.target.value = '';
                mostrarAlerta('Not appointments available in Weekends', 'error', '.formulario');
            } else {
                cita.fecha = e.target.value;
            }
        });  
     }

     function seleccionarHora() {
        const inputHora = document.querySelector('#hora');
        inputHora.addEventListener('input', function(e) {
        
            const horaCita = e.target.value;
            const hora = horaCita.split(":")[0];
            if(hora < 10 || hora > 18) {
                e.target.value = '';
                mostrarAlerta('Appointments only accepted between 10:00 - 18:00', 'error', '.formulario');
            } else {
                cita.hora = e.target.value;
                
            } console.log(cita);
              
     });
     
    }

     function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
        //previene que se muestre el mensaje de alerta varias veces
        const alertaPrevia = document.querySelector('.alerta');
        if(alertaPrevia) {
            alertaPrevia.remove();
        };

        const alerta = document.createElement('DIV');
        alerta.textContent = mensaje;
        alerta.classList.add('alerta');
        alerta.classList.add(tipo);

        const referencia = document.querySelector(elemento);
        referencia.appendChild(alerta);

        if(desaparece) {
            setTimeout(()  => {
                alerta.remove();
            }, 3000);  
        }             
     }

     function mostrarResumen() {
        const resumen = document.querySelector('.contenido-resumen');

        //limpiar el contenido de resumen
        while(resumen.firstChild) {
            resumen.removeChild(resumen.firstChild);
        }

        if(Object.values(cita).includes('') || cita.servicios.length === 0 ) {
            mostrarAlerta('No services or Date or Time selected', 'error', '.contenido-resumen', false);
         
            return;
        }
        
        //formatear el div de resumen
        const { nombre, fecha, hora, servicios } = cita;
       
        // Heading para servicios resumen

        const headingServicios = document.createElement('H3');
        headingServicios.textContent = 'Resume of Services';
        resumen.appendChild(headingServicios);


        servicios.forEach(servicio => {
            const { id, precio, nombre } = servicio;
            const contenedorServicio = document.createElement('DIV');
            contenedorServicio.classList.add('contenedor-servicio');

            const textoServicio = document.createElement('P');
            textoServicio.textContent = nombre;

            const precioServicio = document.createElement('P');
            precioServicio.innerHTML = `<span>Price:</span> $${precio}`;

            contenedorServicio.appendChild(textoServicio);
            contenedorServicio.appendChild(precioServicio);

            resumen.appendChild(contenedorServicio);
        })

        // Heading para cita resumen

        const headingCita = document.createElement('H3');
        headingCita.textContent = 'Resume of Appointment';
        resumen.appendChild(headingCita);
        const nombreCliente = document.createElement('P');
        nombreCliente.innerHTML = `<span>Name:</span> ${nombre}`;

        //formatear la fecha
        const fechaObj = new Date(fecha);
        const mes = fechaObj.getMonth();
        const dia = fechaObj.getDate() + 2;
        const year = fechaObj.getFullYear();

        const fechaUTC = new Date( Date.UTC(year, mes, dia));
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
        const fechaFormateada = fechaUTC.toLocaleDateString('en-US', opciones);

        const fechaCita = document.createElement('P');
        fechaCita.innerHTML = `<span>Date:</span> ${fechaFormateada}`;

        const horaCita = document.createElement('P');
        horaCita.innerHTML = `<span>Time:</span> ${hora}`;

        //boton para crear una cita

        const botonReservar = document.createElement('BUTTON');
        botonReservar.classList.add('boton');
        botonReservar.textContent = 'Get an Appointment';
        botonReservar.onclick = reservarCita;

        resumen.appendChild(nombreCliente);
        resumen.appendChild(fechaCita);
        resumen.appendChild(horaCita);
        resumen.appendChild(botonReservar);
        
     }

     async function reservarCita() {
        const { nombre, fecha, hora, servicios, id } = cita;

        const idServicios = servicios.map( servicio => servicio.id );
        //console.log(cita);
        

       const datos = new FormData();
        
        datos.append('fecha', fecha);
        datos.append('hora', hora);
        datos.append('usuarioId', id);
        datos.append('servicios', idServicios);

       // console.log([...datos]);

       
        try{
            const url = '/api/citas'
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
           const resultado = await respuesta.json();
           console.log(resultado.resultado);
    
           if(resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Appointment succeded",
                text: "We get it!",
                button: 'OK'
              }).then( () => {
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
             })
           }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Failed!",
                text: "Something went wrong!",
            });
        }
        //peticion hacia la api
      }
    
     
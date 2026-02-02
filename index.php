<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Secciones editables y movibles</title>

    <!-- ====== ESTILOS CSS ======
         Todo lo visual: tamaños, colores, márgenes, etc.
         No afecta a la lógica, solo a cómo se ve.
    -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        button {
            padding: 6px 10px;
            margin-top: 5px;
            cursor: pointer;
        }

        /* Contenedor donde van todas las secciones */
        #contenedor {
            max-width: 500px;
        }

        /* Cada sección individual */
        .seccion {
            border: 1px solid #ccc;
            background: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        /* Parte desde donde se puede arrastrar la sección */
        .handle {
            background: #ddd;
            padding: 5px;
            cursor: grab;
            font-weight: bold;
            margin-bottom: 5px;
            border-radius: 3px;
        }

        textarea {
            width: 100%;
            height: 60px;
        }

        /* Contenedor de los botones editar / guardar */
        .acciones {
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <!-- 
        BOTÓN PRINCIPAL
        Cuando se pulsa, ejecuta la función crearSeccion()
    -->
    <button onclick="crearSeccion()">Crear sección</button>

    <!-- 
        CONTENEDOR VACÍO
        Aquí JavaScript irá añadiendo las secciones dinámicamente
    -->
    <div id="contenedor"></div>

    <!-- 
        LIBRERÍA SORTABLEJS
        Permite arrastrar secciones con ratón o dedo (móvil)
    -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <!-- ====== JAVASCRIPT ====== -->
    <script>

        // Contador para llevar la cuenta de cuántas secciones se crean
        let contador = 0;

        /*
            FUNCIÓN: crearSeccion()
            - Se ejecuta al pulsar el botón
            - Pide al usuario el texto
            - Crea una nueva sección con ese contenido
        */
        function crearSeccion() {

            // Pedimos al usuario el contenido de la sección
            const texto = prompt("¿Qué quieres escribir en la sección?");

            // Si pulsa cancelar o no escribe nada, no se crea la sección
            if (texto === null || texto.trim() === "") return;

            // Aumentamos el contador
            contador++;

            // Creamos el elemento <section>
            const seccion = document.createElement("section");

            // Le añadimos la clase CSS "seccion"
            seccion.classList.add("seccion");

            /*
                Insertamos el HTML interno de la sección:
                - handle: para arrastrar
                - p.contenido: texto visible
                - textarea.editor: para editar (oculto al inicio)
                - botones editar / guardar
            */
            seccion.innerHTML = `
                <div class="handle">☰ Arrastrar</div>

                <!-- Texto visible -->
                <p class="contenido">${texto}</p>

                <!-- Área de edición (oculta al principio) -->
                <textarea class="editor" style="display:none;"></textarea>

                <!-- Botones de acción -->
                <div class="acciones">
                    <button onclick="editar(this)">Editar</button>
                    <button onclick="guardar(this)" style="display:none;">Guardar</button>
                </div>
            `;

            // Añadimos la sección al contenedor principal
            document.getElementById("contenedor").appendChild(seccion);
        }

        /*
            FUNCIÓN: editar(boton)
            - Se ejecuta al pulsar "Editar"
            - Cambia la sección a modo edición
        */
        function editar(boton) {

            // Buscamos la sección a la que pertenece ese botón
            const seccion = boton.closest(".seccion");
            // Obtenemos el párrafo con el texto
            const contenido = seccion.querySelector(".contenido");
            // Obtenemos el textarea
            const editor = seccion.querySelector(".editor");
            // Botón guardar
            const guardarBtn = seccion.querySelector("button[onclick='guardar(this)']");

            // Pasamos el texto actual al textarea
            editor.value = contenido.innerText;

            // Ocultamos el texto y mostramos el textarea
            contenido.style.display = "none";
            editor.style.display = "block";

            // Ocultamos botón editar y mostramos guardar
            boton.style.display = "none";
            guardarBtn.style.display = "inline";
        }

        /*
            FUNCIÓN: guardar(boton)
            - Se ejecuta al pulsar "Guardar"
            - Guarda el texto editado y vuelve al modo normal
        */
        function guardar(boton) {

            // Buscamos la sección correspondiente
            const seccion = boton.closest(".seccion");

            // Elementos de la sección
            const contenido = seccion.querySelector(".contenido");
            const editor = seccion.querySelector(".editor");
            const editarBtn = seccion.querySelector("button[onclick='editar(this)']");

            // Guardamos el texto editado en el párrafo
            contenido.innerText = editor.value;

            // Volvemos a mostrar el texto y ocultar el textarea
            editor.style.display = "none";
            contenido.style.display = "block";

            // Mostramos editar y ocultamos guardar
            boton.style.display = "none";
            editarBtn.style.display = "inline";
        }

        /*
            ACTIVAMOS SORTABLE
            - Hace que las secciones se puedan mover
            - Solo desde .handle
        */
        new Sortable(contenedor, {
            animation: 150,      // animación al mover
            handle: ".handle"    // zona desde donde se arrastra
        });

    </script>

</body>
</html>

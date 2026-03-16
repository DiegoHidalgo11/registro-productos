document.addEventListener("DOMContentLoaded", function () {
    cargarDatosIniciales();

    document.getElementById("bodega").addEventListener("change", function () {
        cargarSucursales(this.value);
    });
});

function cargarDatosIniciales() {
    fetch("obtener_datos.php")
        .then(response => response.json())
        .then(data => {
            const bodegaSelect = document.getElementById("bodega");
            const monedaSelect = document.getElementById("moneda");
            const materialesDiv = document.getElementById("materiales");

            data.bodegas.forEach(bodega => {
                const option = document.createElement("option");
                option.value = bodega.id;
                option.textContent = bodega.nombre;
                bodegaSelect.appendChild(option);
            });

            data.monedas.forEach(moneda => {
                const option = document.createElement("option");
                option.value = moneda.id;
                option.textContent = moneda.nombre;
                monedaSelect.appendChild(option);
            });

            materialesDiv.innerHTML = "";
            data.materiales.forEach(material => {
                const label = document.createElement("label");
                label.innerHTML = `<input type="checkbox" name="materiales" value="${material.id}"> ${material.nombre}`;
                materialesDiv.appendChild(label);
            });
        })
        .catch(error => {
            console.error("Error cargando datos:", error);
        });
}

function cargarSucursales(bodegaId) {
    const sucursalSelect = document.getElementById("sucursal");
    sucursalSelect.innerHTML = '<option value="">Seleccione</option>';

    if (bodegaId === "") {
        return;
    }

    fetch("obtener_sucursales.php?bodega_id=" + bodegaId)
        .then(response => response.json())
        .then(data => {
            data.forEach(sucursal => {
                const option = document.createElement("option");
                option.value = sucursal.id;
                option.textContent = sucursal.nombre;
                sucursalSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error cargando sucursales:", error);
        });
}

function guardarProducto() {
    const codigo = document.getElementById("codigo").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const bodega = document.getElementById("bodega").value;
    const sucursal = document.getElementById("sucursal").value;
    const moneda = document.getElementById("moneda").value;
    const precio = document.getElementById("precio").value.trim();
    const descripcion = document.getElementById("descripcion").value.trim();

    const materialesSeleccionados = Array.from(
        document.querySelectorAll('input[name="materiales"]:checked')
    ).map(cb => cb.value);

    const regexCodigo = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/;
    const regexPrecio = /^\d+(\.\d{1,2})?$/;

    if (codigo === "") {
        alert("El código del producto no puede estar en blanco.");
        return;
    }

    if (!regexCodigo.test(codigo)) {
        alert("El código del producto debe contener letras y números");
        return;
    }

    if (codigo.length < 5 || codigo.length > 15) {
        alert("El código del producto debe tener entre 5 y 15 caracteres.");
        return;
    }

    if (nombre === "") {
        alert("El nombre del producto no puede estar en blanco.");
        return;
    }

    if (nombre.length < 2 || nombre.length > 50) {
        alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
        return;
    }

    if (bodega === "") {
        alert("Debe seleccionar una bodega.");
        return;
    }

    if (sucursal === "") {
        alert("Debe seleccionar una sucursal para la bodega seleccionada.");
        return;
    }

    if (moneda === "") {
        alert("Debe seleccionar una moneda para el producto.");
        return;
    }

    if (precio === "") {
        alert("El precio del producto no puede estar en blanco.");
        return;
    }

    if (!regexPrecio.test(precio)) {
        alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
        return;
    }

    if (materialesSeleccionados.length < 2) {
        alert("Debe seleccionar al menos dos materiales para el producto.");
        return;
    }

    if (descripcion === "") {
        alert("La descripción del producto no puede estar en blanco.");
        return;
    }

    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
        return;
    }

    const formData = new FormData();
    formData.append("codigo", codigo);
    formData.append("nombre", nombre);
    formData.append("bodega", bodega);
    formData.append("sucursal", sucursal);
    formData.append("moneda", moneda);
    formData.append("precio", precio);
    formData.append("descripcion", descripcion);

    materialesSeleccionados.forEach(material => {
        formData.append("materiales[]", material);
    });

    fetch("guardar_producto.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(resultado => {
            alert(resultado);
            if (resultado.toLowerCase().includes("exitosamente")) {
                document.getElementById("formProducto").reset();
                document.getElementById("sucursal").innerHTML = '<option value="">Seleccione</option>';
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Ocurrió un error al guardar el producto.");
        });
}
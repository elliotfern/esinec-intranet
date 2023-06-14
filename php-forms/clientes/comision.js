document
  .getElementById("miFormulario")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    var inputs = document.querySelectorAll("#contenedorInputs input");
    var datos = [];

    inputs.forEach(function (input) {
      datos.push({
        comision: input.name,
        valor: input.value,
      });
    });

    // Envío de los datos al servidor utilizando AJAX
    fetch("guardar_datos.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    })
      .then(function (response) {
        // Manejo de la respuesta del servidor
        if (response.ok) {
          console.log("Datos guardados correctamente.");
          // Realizar acciones adicionales si es necesario
        } else {
          console.log("Error al guardar los datos.");
        }
      })
      .catch(function (error) {
        console.log("Error en la solicitud AJAX:", error);
      });
  });

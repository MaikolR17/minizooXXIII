
document.addEventListener("DOMContentLoaded", function () {
  // Elementos del DOM
  const funcSelect = document.getElementById("func");
  const animalList = document.getElementById("list-species");
  const inputs = document.querySelectorAll(
    "input[type=text], textarea, input[type=file]"
  );
  const submitButton = document.getElementById("submit-btn");
  const btn = document.getElementById("btn-darkmode");
  const inputLabels = document.querySelectorAll(".input-label");
  const speciesLabel = document.getElementById("species-label");

  // Cargar datos de especie
  function loadSpecie(id) {
    fetch("get_animal.php?id=" + id)
      .then((response) => response.json())
      .then((data) => {
        if (data) {
          document.getElementById("name").value = data.name || "";
          document.getElementById("alt_name").value = data.alt_name || "";
          document.getElementById("scient_name").value = data.scient_name || "";
          document.getElementById("order").value = data.order || "";
          document.getElementById("family").value = data.family || "";
          document.getElementById("description").value = data.description || "";
          document.getElementById("ecology").value = data.ecology || "";
          document.getElementById("distribution").value =
            data.distribution || "";
        }
      })
      .catch((error) => console.error("Error cargando datos:", error));
  }

  // Descargar QR
  function downloadQR(id) {
    fetch("get_animal.php?id=" + id)
      .then((response) => response.json())
      .then((data) => {
        if (data) {
          fetch(data.qr)
            .then((response) => response.blob())
            .then((blob) => {
              const link = document.createElement("a");
              link.href = URL.createObjectURL(blob);
              link.download = data.name + ".jpg" || "imagen_descargada";
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
              URL.revokeObjectURL(link.href);
            })
            .catch((error) =>
              console.error("Error al descargar la imagen:", error)
            );
        }
      })
      .catch((error) => console.error("Error cargando datos:", error));
  }

  // Manejar cambio de funcionalidad
  funcSelect.addEventListener("change", function () {
    const value = this.value;

    if (value === "delete" || value === "downloadQR") {
      inputs.forEach((input) => {
        input.disabled = true;
        input.value = "";
      });

      inputLabels.forEach((label) => {
        label.classList.add("disabled-label");
      });

      submitButton.type = value === "delete" ? "submit" : "button";
      animalList.disabled = false;
      speciesLabel.style.display = "block";
      animalList.style.display = "block";
      animalList.selectedIndex = 0;
      submitButton.textContent =
        value === "delete" ? "Confirmar Eliminación" : "Descargar QR";
    } else if (value === "update") {
      inputs.forEach((input) => {
        input.disabled = true;
        input.value = "";
      });

      inputLabels.forEach((label) => {
        label.classList.add("disabled-label");
      });

      submitButton.type = "submit";
      animalList.disabled = false;
      speciesLabel.style.display = "block";
      animalList.style.display = "block";
      animalList.selectedIndex = 0;
      submitButton.textContent = "Confirmar Modificación";
    } else if (value === "add") {
      inputs.forEach((input) => {
        input.disabled = false;
        input.value = "";
      });

      inputLabels.forEach((label) => {
        label.classList.remove("disabled-label");
      });

      submitButton.type = "submit";
      animalList.selectedIndex = 0;
      animalList.disabled = true;
      speciesLabel.style.display = "none";
      animalList.style.display = "none";
      submitButton.textContent = "Agregar Especie";
    }
  });

  // Manejar selección de animal
  animalList.addEventListener("change", function () {
    const action = funcSelect.value;

    if (action === "update") {
      inputs.forEach((input) => (input.disabled = false));
      inputLabels.forEach((label) => label.classList.remove("disabled-label"));
      loadSpecie(this.value);
    }
  });

  // Manejar descarga de QR
  submitButton.addEventListener("click", function () {
    const action = funcSelect.value;
    if (action === "downloadQR") {
      downloadQR(animalList.value);
    }
  });

  // Modo oscuro
  btn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem("theme", "dark");
    } else {
      localStorage.setItem("theme", "light");
    }
  });

  // Aplicar tema al cargar
  const theme = localStorage.getItem("theme");
  if (theme === "dark") {
    document.body.classList.add("dark-mode");
  }

  // Estado inicial del formulario
  if (funcSelect.value === "add") {
    speciesLabel.style.display = "none";
    animalList.style.display = "none";
  } else {
    speciesLabel.style.display = "block";
    animalList.style.display = "block";
  }
});

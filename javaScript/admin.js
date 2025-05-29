import { validateSpecie} from "./client_side_validation.js";  

document.addEventListener("DOMContentLoaded", function () {
  // Elementos del DOM
  const funcSelect = document.getElementById("func");
  const animalList = document.getElementById("list-species");
  const inputs = document.querySelectorAll(
    "input[type=text], textarea, input[type=file],input[type=number]"
  );

  const inputsToValidate = document.querySelectorAll("input[type=text],textarea,input[type=file]");
  const submitButton = document.getElementById("submit-btn");
  const btn = document.getElementById("btn-darkmode");
  const inputLabels = document.querySelectorAll(".input-label");
  const speciesLabel = document.getElementById("species-label");

  //validaciones del lado del cliente


  function validateSpecieHandler(event){
    validateSpecie(funcSelect,animalList,event.target);
    // const start = Date.now();
    // while (Date.now() - start < 50) {}
    let validate = true;
    inputsToValidate.forEach(input=>{
      if(input.dataset.valid === 'false'){
        validate = false;
      }
    });
    if(validate){
      submitButton.disabled = false;
    }else{
      submitButton.disabled = true;
    } 
    
  }

  function addValidationEvents(){
    inputsToValidate.forEach(input=>{
      if(input.type === 'file'){
        input.addEventListener('change',validateSpecieHandler);
      }else{
        input.addEventListener("input",validateSpecieHandler);
        input.addEventListener("change", validateSpecieHandler);
      }
    });
  }

  function removeValidationEvents(){
    submitButton.disabled = false;
    inputsToValidate.forEach(input=>{
      input.dataset.valid = 'false';
      input.classList.remove("input_error");
      input.classList.remove("input_success");
      if(input.type === 'file'){
        input.removeEventListener('change', validateSpecieHandler);
      }else{
        input.removeEventListener("input", validateSpecieHandler);
        input.removeEventListener("change", validateSpecieHandler);
      }
    })
  }

  addValidationEvents();


  // Cargar datos de especie
  function loadSpecie(id) {
    fetch(`get_animal.php?id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        if (data && !data.error) {
          document.getElementById("place").value = data.place || "";
          document.getElementById("name").value = data.name || "";
          document.getElementById("alt_name").value = data.alt_name || "";
          document.getElementById("scient_name").value = data.scient_name || "";
          document.getElementById("specie_order").value = data.specie_order || "";
          document.getElementById("family").value = data.family || "";
          document.getElementById("description").value = data.description || "";
          document.getElementById("ecology").value = data.ecology || "";
          document.getElementById("distribution").value = data.distribution || "";
        } else {
          console.error("Especie no encontrada:", data.error);
        }
      })
      .catch((error) => console.error("Error cargando datos:", error));
  }

  // Manejar cambio de funcionalidad
  funcSelect.addEventListener("change", function () {
    const value = this.value;

    if (value === "delete") {
      removeValidationEvents();
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
      submitButton.textContent = "Confirmar Eliminación";
    } else if (value === "update") {
      addValidationEvents();
      submitButton.disabled = true;
      inputsToValidate.forEach(input=>{
        input.dataset.valid = "false";
        input.classList.remove("input_success");
        input.classList.remove("input_error");
      })
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
      submitButton.disabled = true;
      inputsToValidate.forEach(input=>{
        input.dataset.valid = "false";
        input.classList.remove("input_success");
        input.classList.remove("input_error");
      })
      addValidationEvents();
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
      submitButton.disabled = false;
      inputsToValidate.forEach(input=>{
        input.dataset.valid = "true";
        input.classList.remove("input_error");
        input.classList.add("input_success");
      })
      inputs.forEach((input) => (input.disabled = false));
      inputLabels.forEach((label) => label.classList.remove("disabled-label"));
  
      const selectedId = this.value;
      if (selectedId) {
        loadSpecie(selectedId); 
      }
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

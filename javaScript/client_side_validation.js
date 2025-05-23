const functionality = document.querySelector("#functionality");
//el codigo solo se ejecuta si el select esta en agregar o modificar
functionality.addEventListener("change",()=>{
if(functionality.value === "add" || functionality.value === "update"){

/**
 * Valida atributos de especies repetidas
 * @param {string} atribute - Recibe el atributo de la especie ej(name, scient_name, alt_name)
 * @returns {boolean} False en caso de encontrar un atributo repetido y true en caso contrario 
 */
function validateSpecie(attribute){
    fetch(`../PHP/get_all_animals.php?atribute=${attribute}`)
      .then((response) => response.json())
      .then((data) => {
        if(attribute == "name"){
          const specieName = document.getElementById("name").value.toLowerCase();
          if(data.toLowerCase().includes(specieName)){
            return false;
          }
          return true;
        }else if(attribute == "scient_name"){
          const scientName = document.getElementById("scient_name").value.toLowerCase();
          if(data.toLowerCase().includes(scientName)){
            return false;
          }
          return true;
        }else{
            const altName = document.getElementById("alt_name").value.toLowerCase();
            if(data.toLowerCase().includes(altName)){
                return false;
            }
            return true;
        }
      })
}
/**
 * Calcula si una cadena esta vacia
 * @param {*} inputText - Recibe un elemento del DOM
 * @returns {boolean} -retorna true en caso que la cadena esta vacia y false si no lo esta 
 */
function isEmpty(inputText){
    return inputText.value.length === 0;
}

/**
 * Comprueba todos los campos ingresados. Deshabilita el boton de envio si no se cumplen las validaciones, en caso contrario lo habilita 
 * @returns {void}
 */
function validateAll(){
    if(!validateSpecie("name") || !validateSpecie("scient_name") || 
    !validateSpecie("alt_name") || isEmpty(order) || isEmpty(family) || 
    isEmpty(ecology) || isEmpty(distribution) || isEmpty(description) || 
    document.querySelector("input[type=file]").files.length === 0){
        submitButton.disabled = true;
    }else{
        submitButton.disabled = false;
    }
}

const specieName = document.getElementById("name");
const scientName = document.getElementById("scient_name");
const altName = document.getElementById("alt_name");
const order = document.getElementById("name");
const family =  document.getElementById("family");
const description = document.getElementById("description");
const ecology = document.getElementById("ecology");
const distribution = document.getElementById("distribution");
const requiredElements = document.querySelectorAll("textarea, #family,#order");
const submitButton = document.getElementById("submit-btn");
const inputs = document.querySelectorAll("input[type=text], textarea, input[type=file],input[type=number]");
const errorMsg = document.querySelector(".error");
const successMsg = document.querySelector(".success");

//eventos para validar cada input

specieName.addEventListener("input",()=>{
    if(specieName.value.length === 0){
        specieName.classList.remove("imput_error");
    }
    else if(validateSpecie("name")){
        specieName.classList.remove("input_error");
        specieName.classList.add("input_success");
        validateAll();
    }else{
        specieName.classList.remove("input_success");
        specieName.classList.add("input_error");
    }
});

scientName.addEventListener("input",()=>{
    if(scientName.value.length === 0){
        scientName.classList.remove("imput_error");
        specieName.classList.remove("input_success");
    }
    else if(validateSpecie("scient_name")){
        scientName.classList.remove("input_error");
        scientName.classList.add("input_success");
        validateAll();
    }else{
        scientName.classList.remove("input_success");
        scientName.classList.add("input_error");
    }
});

altName.addEventListener("input",()=>{
    if(altName.value.length === 0){
        altName.classList.remove("imput_error");
        altName.classList.remove("input_success");
    }
    else if(validateSpecie("alt_name")){
        altName.classList.remove("input_error");
        altName.classList.add("input_success");
        validateAll();
    }else{
        altName.classList.remove("input_success");
        altName.classList.add("input_error");
    }
});

requiredElements.forEach(element=>element.addEventListener("click", ()=>{
    if(element.value.length === 0){
        element.classList.remove("input_success");
    }else{
        element.classList.add("input_success");
        validateAll();
    }
}));

}
});






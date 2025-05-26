
/**
 * Calcula si una cadena esta vacia
 * @param {HTMLElement} inputText - Recibe un elemento del DOM
 * @returns {boolean} -retorna true en caso que la cadena esta vacia y false si no lo esta 
 */
function isEmpty(inputText){
    return inputText.value.length === 0;
}

/**
 * Comprueba todos los campos ingresados. Deshabilita el boton de envio si no se cumplen las validaciones, en caso contrario lo habilita 
 * @param {HTMLElement} func - Recibe el objeto de funcionalidad
 * @param {HTMLElement} speciesList - Recibe el objeto de seleccion de especies
 * @param {HTMLElement} input - Recibe el objeto input
 * @param {HTMLElement} btn - Recibe el objeto boton de envio
 * @returns {boolean} True si se valida correctamente y false si no
 */
export function validateAll(func,speciesList,input){
    if(!validateSpecie("name",func,speciesList,input) || !validateSpecie("scient_name",func,speciesList,input) || 
    !validateSpecie("alt_name",func,speciesList,input) || isEmpty(input) || isEmpty(input) || 
    isEmpty(input) || isEmpty(input) || isEmpty(input)){
        console.log("No se validaron todos los inputs");
        return false;
    }else{
        console.log("Se validaron todos los inputs");
        return true;
    }
}

/**
 * Valida atributos de especies repetidas
 * @param {string} atribute - Recibe el atributo de la especie ej(name, scient_name, alt_name)
 * @param {HTMLElement} func - Recibe el objeto de funcionalidad
 * @param {HTMLElement} speciesList - Recibe el objeto de seleccion de especies
 * @param {HTMLElement} input - Recibe el objeto input
 * @returns {boolean} False en caso de encontrar un atributo repetido y true en caso contrario 
 */
function validateSpecie(attribute,func,speciesList,input){
    fetch(`get_all_animals.php?attribute=${attribute}`)
      .then((response) => response.json())
      .then((data) => {
        const result = data.map(item => item.toLowerCase());
        const specie_selected = speciesList.value || "";
        const inputValue = input.value.toLowerCase() || "";
        let specie_attribute;

        async function getAttributeValue(){
          specie_attribute = await getSpecieAttribute(specie_selected, attribute);
          return specie_attribute;
        }
        (async () => {await getAttributeValue();})();
        console.log(result);
        console.log(specie_selected);
        console.log(specie_attribute);
        if(func.value === 'add'){
          if(result.includes(inputValue)) {
            console.log("Ya existe esta especie"); 
            return false;
          }
          console.log("validado");
          return true;
        }else if(func.value === 'update'){
          if(!result.includes(inputValue)){
            console.log("validado"); 
            return true;
          }
          else if(result.includes(inputValue) && compareAttributes(inputValue,specie_selected,attribute)){
            console.log("validado");
            return true;
          }else if(!result.includes(inputValue)){
            console.log("Validado");
            return true;
          }
          console.log("Ya existe esta especie");
          return false;
        }
      }).catch(error=>console.log("Error al obtener los datos ",error));
}

/**
 * Obtiene el nombre, nombre cient y nombre alt de la especie mediante su ID
 * @param {int}-id -Recibe el id de la especie
 * @param {string}-attribute -Recibe el atributo que se necesita conocer
 * @returns {string} El atributo de la especie o una cadena vacia en caso de encontrarlo
 */
async function getSpecieAttribute(id,attribute){
    if(id === "") return "";
    try{
    const response = await fetch(`get_animal.php?id=${id}`);
    const data = await response.json();
        console.log(data);
        if(attribute === 'name'){ 
          console.log(data.name);
          return data.name;
        }
        else if(attribute === 'scient_name') return data.scient_name;
        else return data.alt_name;
      }catch(error){
        console.log("Error al recibir los datos ",error);
      }
}

/**
 * Valida el input en tiempo real
 * @param {HTMLElement} object - Recibe el input 
 * @param {string} attribute - Recibe el atributo de la pespecie
 * @param {HTMLElement} action - Recibe la funcionalidad 
 * @param {HTMLElement} btn - Recibe el boton de envio del formulario
 * @param {HTMLElement} speciesList - Recibe el select de especies
 */
export function validateInput(object,attribute,action,btn,speciesList){
    if(object.value.length === 0){
        object.classList.remove("imput_error");
        object.classList.remove("input_success");
    }
    else if(validateSpecie(attribute,action,speciesList,object)){
        object.classList.remove("input_error");
        object.classList.add("input_success");
        if(action.value === 'add'){
          if(validateAll(action,speciesList,object) && document.querySelector("input[type=file]").files.length === 1){
            console.log("Boton desbloqueado");
            btn.disabled = false;
          }else{
            console.log("Boton blockeado");
            btn.disabled = true;
          }
        }else if(action.value === 'update'){
          if(validateAll(action,speciesList,object) && document.querySelector("input[type=file]").files.length === 1){
            console.log("Boton desbloqueado");
            btn.disabled = false;
          }else if(validateAll(action,speciesList,object) && document.querySelector("input[type=file]").files.length === 0){
            console.log("Boton desbloqueado");
            btn.disabled = false;
          }else{
            console.log("Boton bloqueado");
            btn.disabled = true;
          }
        }
      }else{
        object.classList.remove("input_success");
        object.classList.add("input_error");
        btn.disabled = true;
      }
}

















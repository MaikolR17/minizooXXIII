
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
 * @param {HTMLElement} func - Recibe el objeto de funcionalidad
 * @param {HTMLElement} speciesList - Recibe el objeto de seleccion de especies
 * @param {HTMLElement} input - Recibe el objeto input
 * @param {HTMLElement} btn - Recibe el objeto boton de envio
 * @returns {boolean} True si se valida correctamente y false si no
 */
export function validateAll(func,speciesList,input,btn){
    if(!validateSpecie("name",func,speciesList) || !validateSpecie("scient_name",func,speciesList) || 
    !validateSpecie("alt_name",func,speciesList) || isEmpty(input) || isEmpty(input) || 
    isEmpty(input) || isEmpty(input) || isEmpty(input)){
        btn.disabled = true;
        return false;
    }else{
        btn.disabled = false;
        return true;
    }
}

/**
 * Valida atributos de especies repetidas
 * @param {string} atribute - Recibe el atributo de la especie ej(name, scient_name, alt_name)
 * @param {*} func - Recibe el objeto de funcionalidad
 * @param {*} speciesList - Recibe el objeto de seleccion de especies
 * @returns {boolean} False en caso de encontrar un atributo repetido y true en caso contrario 
 */
function validateSpecie(attribute,func,speciesList){
    fetch(`get_all_animals.php?attribute=${attribute}`)
      .then((response) => response.json())
      .then((data) => {
        const specieSelected = speciesList.value || "";
        const nameAttribute = getSpecieAttribute(specieSelected,"name")?.toLowerCase() || "";
        const scientNameAttribute = getSpecieAttribute(specieSelected,"scient_name")?.toLowerCase() || "";
        const altNameAttribute = getSpecieAttribute(specieSelected,"alt_name")?.toLowerCase() || "";
        const result = data.map(item => item.toLowerCase());
        if(attribute == "name"){
          const specieNamee = document.getElementById("name").value.toLowerCase();
          if(func.value ==='add' && result.includes(specieNamee)){
            return false;
          }else if(result.includes(specieNamee) && nameAttribute !== specieNamee){
            return false;
          }
          return true;
        }else if(attribute == "scient_name"){
          const scientNamee = document.getElementById("scient_name").value.toLowerCase();
          if(func.value ==='add' && result.includes(scientNamee)){
            return false;
          }else if(result.includes(scientNamee) && scientNameAttribute !== scientNamee){
            return false;
          }
          return true;
        }else{
            const altNamee = document.getElementById("alt_name").value.toLowerCase();
            if(func.value ==='add' && result.includes(altNamee)){
                return false;
            }else if(result.includes(altNamee) && altNameAttribute !== altNamee){
                return false;
            }
            return true;
        }
      })
}

/**
 * Obtiene el nombre, nombre cient y nombre alt de la especie mediante su ID
 * @param {int}-id -Recibe el id de la especie
 * @param {string}-attribute -Recibe el atributo que se necesita conocer
 * @returns {string} El atributo de la especie o una cadena vacia en caso de encontrarlo
 */
function getSpecieAttribute(id,attribute){
    if(id === "") return "";
    fetch(`get_animal.php?id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        if(attribute === 'name') return data.name;
        else if(attribute === 'scient_name') return data.scient_name;
        else return data.alt_name;
      }).catch((error)=>console.log("Error al leer los datos: ",error));
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
    else if(validateSpecie(attribute,action,speciesList)){
        object.classList.remove("input_error");
        object.classList.add("input_success");
        if(validateAll(action,speciesList,object,btn) && document.querySelector("input[type=file]").files.length === 0 && action === 'add'){
            btn.disabled = true;
        }else if(validateAll(action,speciesList,object,btn) && document.querySelector("input[type=file]").files.length === 1 && action === 'add'){
            btn.disabled = false;
        }else if(validateAll(action,speciesList,object,btn) && action === 'update'){
            btn.disabled = false;
        }
    }else{
        object.classList.remove("input_success");
        object.classList.add("input_error");
    }
}

















/**
 * Valida la especie, realiza la accion correspondiente a la validacion
 * @param {HTMLElement} func - Recibe el objeto de funcionalidad
 * @param {HTMLElement} speciesList - Recibe el objeto de seleccion de especies
 * @param {HTMLElement} input - Recibe el objeto input
 * @returns {void} 
 */
export function validateSpecie(func,speciesList,input){
    fetch(`get_all_animals.php?attribute=${input.id}&id=${speciesList.value}`)
      .then((response) => response.json())
      .then((data) => {
        const result = data[0].map(item => item? item.toLowerCase():"");
        const inputValue = input.value.trim().toLowerCase() || "";
        if(input.value.trim().length === 0 && input.id !== 'scient_name' && input.id !== 'alt_name'){
          input.classList.remove("input_success");
          input.classList.remove("input_error");
          input.setAttribute('data-valid','false');
          console.log("Campo vacio invalido"); 
        }
        else if(func.value === 'add'){
          if(input.id === 'name'){
            if(result.includes(inputValue)) {
              console.log("Ya existe una especie con este nombre");
              input.setAttribute('data-valid','false');
              input.classList.remove("input_success");
              input.classList.add("input_error"); 
            }else{
              console.log("Nombre valido");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success");
            }
          }else if(input.id === 'scient_name'){
            if(input.value.trim().length === 0){
              console.log("Nombre cient vacio y valido");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.remove("input_success");
            }else if(result.includes(inputValue)) {
              console.log("Ya existe una especie con este nombre cient");
              input.setAttribute('data-valid','false');
              input.classList.remove("input_success");
              input.classList.add("input_error"); 
            }else{
              console.log("Nombre cient valido");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success");
            }
          }else if(input.id === 'alt_name'){
            if(input.value.trim().length === 0){
              console.log("Nombre alt vacio y valido");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.remove("input_success");
            }else if(result.includes(inputValue)) {
              console.log("Ya existe una especie con este nombre cient");
              input.setAttribute('data-valid','false');
              input.classList.remove("input_success");
              input.classList.add("input_error"); 
            }else{
              console.log("Nombre cient valido");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success");
            }
          }else if(input.type === 'file'){
            if(input.files.length !== 0){
              console.log("Archivo valido");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success");
            }else{
              console.log("Archivo no valido");
              input.setAttribute("data-valid","true");
            }
          }else if(input.value.trim().length > 0){
              input.setAttribute("data-valid","true");
              input.classList.add("input_success");
              console.log("Campo obligatorio validado");
          }
        }else if(func.value === 'update'){
          if(input.id === 'name'){
            if(!result.includes(inputValue)){
              console.log("Nombre validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success"); 
            }else if(result.includes(inputValue) && inputValue == data[1].name.toLowerCase()){
              console.log("Nombre validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success"); 
            }else{
              console.log("Nombre invalido");
              input.setAttribute("data-valid","false");
              input.classList.remove("input_success");
              input.classList.add("input_error");
            }
          }else if(input.id === 'scient_name'){
            const existentScientName = data[1].scient_name? data[1].scient_name.toLowerCase() : "";
            if(input.value.length === 0){
              console.log("nombre cient validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success");
            }
            else if(!result.includes(inputValue)){ 
              console.log("Nombre cient validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success"); 
            }else if(result.includes(inputValue) && inputValue === existentScientName){
              console.log("Nombre cient validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success"); 
            }else{
              console.log("Nombre cient invalido");
              input.setAttribute("data-valid","false");
              input.classList.remove("input_success");
              input.classList.add("input_error");
            }
          }else if(input.id === 'alt_name'){
            const existentAltName = data[1].alt_name ? data[1].alt_name.toLowerCase() : "";
            if(input.value.trim().length === 0){
              console.log("Nombre alt validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.remove("input_success");
            }
            else if(!result.includes(inputValue)){
              console.log("Nombre alt validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success"); 
            }else if(result.includes(inputValue) && inputValue === existentAltName){
              console.log("Nombre alt validado");
              input.setAttribute("data-valid","true");
              input.classList.remove("input_error");
              input.classList.add("input_success"); 
            }else{
              console.log("Nombre alt invalido");
              input.setAttribute("data-valid","false");
              input.classList.remove("input_success");
              input.classList.add("input_error");
            }
          }else if(input.value.trim().length > 0){
            console.log("Campos obligatorios validados");
            input.setAttribute("data-valid","true");
            input.classList.remove("input_error");
            input.classList.add("input_success");
          }
        }
        }).catch(error=>console.log("Error al obtener los datos ",error));
}

















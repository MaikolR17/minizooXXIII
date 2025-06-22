document.addEventListener("DOMContentLoaded", ()=>{
    const inputs = document.querySelectorAll("input[type=text],input[type=password]");
    const action = document.querySelector("#func");
    const roleList = document.querySelector("#role_list");
    const userList = document.querySelector("#user_list");
    const newRoleList = document.querySelector('#new_role');
    const selects = document.querySelectorAll("#new_role,#user_list");
    const submitBtn = document.querySelector("#submit-btn");

    function resetSelect(selects){
        selects.forEach(select=>select.selectedIndex = 0);
    }
    
    //manejar accion
    action.addEventListener("change", function(){
        const value = this.value;
        resetSelect(selects);
        roleList.selectedIndex = 0;
        if(value === 'add'){
            inputs.forEach(input=>{
                input.required = true;
                input.disabled = false;
            });
            userList.required = false;
            userList.disabled = true;
            newRoleList.required = false;
            newRoleList.disabled = true;
            submitBtn.textContent = "Crear usuario";
        }else if(value === 'update'){
            inputs.forEach(input =>{
                input.required = false;
                input.disabled = true;
            });
            userList.disabled = true;
            userList.required = true;
            newRoleList.disabled = true;
            newRoleList.required = true;
            submitBtn.textContent = "Modificar rol";
        }else {
            inputs.forEach(input =>{
                input.required = false;
                input.disabled = true;
            });
            userList.disabled = true;
            userList.required = true;
            newRoleList.required = false;
            newRoleList.disabled = true;
            submitBtn.textContent = 'Eliminar usuario';
        }
    });


    roleList.addEventListener("change", ()=>{
        resetSelect(selects);
        if(action.value === 'update' || action.value === 'delete'){
            userList.disabled = false;
        }
        userList.innerHTML = `<option value="" selected disabled>--Seleccione una opcion--</option>`;
        fetch(`https://juanxxiiizoo.infinityfreeapp.com/APIS/api_rol.php?id_role=${roleList.value}`)
        .then(response => response.json())
        .then(data =>{
            if(data.error){
                console.log(data.error);
            }else{
                data.forEach(datito =>{
                    userList.innerHTML += `<option value="${datito.id}">${datito.username}</option>`; 
                    console.log("escritura en el html");
                });
            }
        
        }).catch(error=>console.log("Ocurrio un error en la respuesta ",error));
    });

    userList.addEventListener("change",function(){
        if(action.value === 'update'){
            newRoleList.disabled = false;
        }

    });

    


});
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Administradores</title>
    <style>
        .search-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .search-box {
            width: 300px;
            padding: 10px 15px;
            border: 2px solid #ccc;
            border-radius: 25px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-box:focus {
            border-color: #007BFF;
            outline: none;
        }

        ::placeholder {
            color: #999;
        }
        ol{
            padding: 0;
            list-style: none;
        }
        .container{
            padding: 20px 80px;
            margin: 0 auto;
            max-width: 700px;
        }
        li{
            font-size: 16px;
            font-family: sans-serif;
            margin-bottom: 5px;
        }
        body{
            background-color: #f5f5f5;
        }
        h1{
            color: #222;
        }               
    </style>
    <!-- Logo de pestaña -->
    <link rel="icon" type="image/png" href="img/LogoPNG.png">
</head>
<body>
    <div class="search-container">
        <input type="text" class="search-box" placeholder="Buscar..." />
    </div>
    <div class="container">
        <h1>Historial de administradores</h1>
        <ol>
            <?php
                $file = "../reg/AdminHistory.json";
                $content = file_exists($file) ? file_get_contents($file) : [];
                $data = json_decode($content, true)? : [];
                foreach($data as $d){
                    echo "<li class=\"history-list\" ";
                    echo "data-admin = \"".$d['admin']."\" ";
                    echo "data-action = \"".$d['action']."\" ";
                    echo "data-specie = \"".$d['specie']."\" ";
                    echo "data-id = \"".$d['id']."\" >";
                    echo "<strong>".$d['date']." </strong>";
                    echo "<span class=\"admin\"><strong>".$d['admin']."</strong></span>"." <span class =\"action\"> ".$d['action']."</span> la especie de nombre \"".$d['specie']."\" y id = ".$d['id']."\"";
                    echo "</li>";
                }
            ?>
        </ol>
    </div>
    <script>
        const elements = document.querySelectorAll(".history-list");
        const input = document.querySelector("input");
        const adminNames = document.querySelectorAll(".admin");
        const adminActions = document.querySelectorAll(".action");
        document.addEventListener("DOMContentLoaded", ()=>{
            adminNames.forEach(name =>{
                if(name.textContent === 'Oscar Fretes') name.style.color = "#FF8C00";
                else if(name.textContent === 'Yoselyn Fretes') name.style.color = "#FF1493";
                else if(name.textContent === 'Jazmin Fernandez') name.style.color = "#8A2BE2";
                else if(name.textContent === 'Fernando Salcedo') name.style.color = "#4B0082";
                else if(name.textContent === 'Sebastian Stumpfs') name.style.color = "#1E90FF";
                else if(name.textContent === 'Emanuel Castelvi') name.style.color = "#FF4500";
                else if(name.textContent === 'Jonathan Ceraso') name.style.color = "#DC143C";
                else if(name.textContent === 'Alexix Franco') name.style.color = "#00CED1";
                else if(name.textContent === 'Adrihan Sandoval') name.style.color = "#32CD32";
            })
            input.addEventListener("input",()=>{
                elements.forEach(element =>{
                    const adminName = element.dataset.admin.toLowerCase();
                    const action = element.dataset.action.toLowerCase();
                    const specie = element.dataset.specie.toLowerCase();
                    const id = element.dataset.id;
                    const search = input.value.trim().toLowerCase();
                    if(search.length === 0){
                        element.style.display = "block";
                    }
                    else if(adminName.includes(search) || action.includes(search) || specie.includes(search) || id.includes(search)){
                        element.style.display = "block";
                    }else{
                        element.style.display = "none";
                    }
                })
            })
        })
    </script>
</body>
</html>
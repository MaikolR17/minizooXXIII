document.addEventListener("DOMContentLoaded",()=>{
const shareButton = document.getElementById("share-button");
if(!shareButton) return;

const specieName = document.querySelector("h1");
const currentUrl = window.location.href;
//al compartir se envia una URL nueva
const newUrl = currentUrl.replace("&ref=java","").trim();

//Api para compartir
shareButton.addEventListener("click", async ()=>{
    if(navigator.share){
        try{
            await navigator.share({
                title: 'Explora todas las especies del Mini-Zoo Juan XXII',
                text: 'Mira, mi animal interno es: "'+specieName.textContent+'"',
                url: newUrl
            });
        }catch(error){
            console.error("Ha ocurrido un error al compartir",error);
        } 
    }
    });
});
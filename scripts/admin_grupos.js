"use strict"

 const containers_grupos = document.querySelectorAll(".grupos-container");
 const h2s = document.querySelectorAll(".admin-grupos-selector h2");

 h2s.forEach(titulo=>{
    titulo.addEventListener("click", (evento)=>{
        const pulsado = evento.target
        let data = pulsado.getAttribute("data-type")
        if(!titulo.classList.contains("tipo-activo")){
            h2s.forEach(titulo => titulo.classList.remove("tipo-activo"))
            titulo.classList.add("tipo-activo");
        }
        containers_grupos.forEach(container =>{
            if(container.getAttribute("data-section") == data){
                container.classList.add("container-activo")
            }else{
                container.classList.remove("container-activo")
            }
        })
    })
 })
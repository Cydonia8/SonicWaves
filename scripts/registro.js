"use strict"

const login_picker = document.querySelectorAll(".form-option-picker h3")
const forms = document.querySelectorAll(".forms-container form")
const view_pass = document.querySelectorAll(".view-pass")

document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
login_picker.forEach(titulo =>{
    titulo.addEventListener("click", (evento)=>{
        const pulsado = evento.target
        let data_form = pulsado.getAttribute("data-form-title")
        switch(data_form){
            case "group":
                document.body.style.backgroundImage = "url('../media/assets/register_bg2.0.jpg')"
                break
            case "user":
                document.body.style.backgroundImage = "url('../media/assets/register_bg1.jpg')"
                break
            case "disc":
                document.body.style.backgroundImage = "url('../media/assets/register_bg3.jpg')"
                break
        }
        if(!pulsado.classList.contains("active")){
            login_picker.forEach(titulo => titulo.classList.remove("active"))
            pulsado.classList.add("active")
        }
        forms.forEach(form => {
            if(form.getAttribute("data-form") == data_form){
                forms.forEach(form => form.classList.remove("active-form"))
                form.classList.add("active-form")
            }
        })
    })
})

view_pass.forEach(element =>{
    element.addEventListener("click", changePasswordInput)
})

function changePasswordInput(evento){
    const pulsado = evento.target
        if(pulsado.getAttribute("name") == "eye-outline"){
            pulsado.setAttribute("name", "eye-off-outline")
            pulsado.previousElementSibling.type = "text"
        }else{
            pulsado.setAttribute("name", "eye-outline")
            pulsado.previousElementSibling.type = "password"
        }
}


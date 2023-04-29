"use strict"
const section_form = document.querySelector(".form-group-completition")
const btn_completar_info = document.querySelector(".btn-completar-info-inicial")
const section_group = document.querySelector(".banner-group-main")
let bg = section_group.getAttribute("data-bg")
section_group.style.height="50vh"
section_group.style.backgroundImage=`url('${bg}')`
section_group.style.backgroundSize="cover"
// btn_completar_info.addEventListener("click", () => {
//     section_form.classList.add("hide")
// })
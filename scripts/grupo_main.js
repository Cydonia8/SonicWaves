"use strict"
const section_form = document.querySelector(".form-group-completition")
const btn_completar_info = document.querySelector(".btn-completar-info-inicial")
const section_group = document.querySelector(".banner-group-main")
const edit_avatar  = document.querySelector(".icon-edit-avatar-group")
const avatar_group = document.querySelector(".banner-group-main-avatar-link")
const close_modal = document.querySelector(".close-modal-update-avatar")
const section_update_avatar = document.querySelector(".update-avatar-photo")


let bg = section_group.getAttribute("data-bg")
// section_group.style.height="70vh"
section_group.style.backgroundImage=`url('${bg}')`
section_group.style.backgroundSize="cover"
// btn_completar_info.addEventListener("click", () => {
//     section_form.classList.add("hide")
// })

avatar_group.addEventListener("mouseenter", ()=>{
    edit_avatar.classList.remove("d-none")
})
avatar_group.addEventListener("mouseleave", ()=>{
    edit_avatar.classList.add("d-none")
})
avatar_group.addEventListener("click", (event)=>{
    event.preventDefault()
    section_update_avatar.classList.add("d-flex")
    section_update_avatar.classList.remove("d-none")
})

close_modal.addEventListener("click", ()=>{
    section_update_avatar.classList.remove("d-flex")
    section_update_avatar.classList.add("d-none")
})
"use strict"
const button = document.querySelector("button")
const main = document.getElementById("main-content")
const loader = document.querySelector(".loader")
let albums
getAlbums()

// button.addEventListener("click", async ()=>{
    
//     await createDOMAlbums(main, albums, createAlbumPreview)
//     loader.classList.add("d-none")
// })
async function getAlbums(){
    loader.classList.remove("d-none")
    const respuesta = await fetch('../api_audio/albums.php')
    const datos = await respuesta.json()
    albums = datos['datos']
    createDOMAlbums(main, albums, createAlbumPreview)
    loader.classList.add("d-none")
}

async function createDOMAlbums(dom, album, element){
    const contenedor = document.createElement("section")
    contenedor.classList.add("d-flex", "container-fluid", "gap-3")
    dom.appendChild(contenedor)
    album.forEach(album=>{
        const elemento = element(album)
        contenedor.appendChild(elemento)
    })
}

function createAlbumPreview(album){
    const dom = document.createElement("div")
    dom.classList.add("d-flex", "flex-column", "border", "rounded", "align-items-center", "pt-2", "pb-2")
    dom.innerHTML=`<img class="w-75 rounded" src="${album.foto}">
                    <a href="">${album.titulo}</a>
                    <a>${album.autor}</a>`
    return dom
}
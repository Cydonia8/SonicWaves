"use strict"
const button = document.querySelector("button")
const main = document.getElementById("main-content")
const loader = document.querySelector(".loader")
const audio = document.querySelector("audio")
const link_inicio = document.getElementById("home-link")

let albums = []

getAlbums()

// button.addEventListener("click", async ()=>{
    
//     await createDOMAlbums(main, albums, createAlbumPreview)
//     loader.classList.add("d-none")
// })

link_inicio.addEventListener("click", initializePlayer)

async function initializePlayer(evt){
    evt.preventDefault()
    console.log(albums)
}

async function getAlbums(){
    loader.classList.remove("d-none")
    const respuesta = await fetch('../api_audio/albums.php')
    const datos = await respuesta.json()
    albums = datos['datos']
    createDOMAlbums(main, albums, createAlbumPreview)
    const link_album = document.querySelectorAll("a.link-album")
    link_album.forEach(async link=>{
        link.addEventListener("click", async (evt)=>{
            evt.preventDefault()
            let id = evt.target.getAttribute("data-id")
            let album = await getAlbum(id)
            console.log(album)
            await createAlbumView(album, main)
        })
    })
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
                    <a class="link-album" data-id="${album.id}" href="">${album.titulo}</a>
                    <a>${album.autor}</a>`
    return dom
}

async function getAlbum(id){
    const respuesta = await fetch(`../api_audio/album_peticion.php?id=${id}`)
    const datos = await respuesta.json()
    return datos["datos"]
}

async function createAlbumView(album, dom){
    console.log(album)
    const element = document.createElement("div")
    element.innerHTML=`<img class="w-50" src="${album[0].foto}">
                            <h2>${album[0].titulo}</h2>
                            <h3>${album[0].autor}</h3>`
    dom.innerHTML=''
    dom.appendChild(element)
}
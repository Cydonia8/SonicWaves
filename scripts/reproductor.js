"use strict"
const button = document.querySelector("button")
const main = document.getElementById("main-content")
const loader = document.querySelector(".loader")
const link_inicio = document.getElementById("home-link")

const seek = document.getElementById("seek")
const bar2 = document.getElementById("bar2")
const dot = document.querySelector(".master-play .time-bar .dot")
const volume_input = document.getElementById("volume-slider")
const volume_bar = document.querySelector(".vol-bar")
const volume_dot = document.querySelector(".vol-dot")

const current_time = document.getElementById("current-time")
const end_time = document.getElementById("end-time")
const play_pause = document.getElementById("play-pause")
const audio = new Audio()
console.log(dot)
let albums = []

getAlbums()
document.addEventListener("DOMContentLoaded", async ()=>{
    const respuesta = await fetch('../api_audio/canciones.php')
    const datos = await respuesta.json()
    let cancion = datos['datos']
    audio.src=cancion[0].archivo
})
// button.addEventListener("click", async ()=>{
    
//     await createDOMAlbums(main, albums, createAlbumPreview)
//     loader.classList.add("d-none")
// })
play_pause.addEventListener("click", ()=>{
    if(audio.paused){
        audio.play()
        play_pause.setAttribute("name", "pause-outline")
    }else{
        audio.pause()
        play_pause.setAttribute("name", "play-outline")
    }
})
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
//Actualizar tiempo actual de la canción
audio.addEventListener("timeupdate", ()=>{
    let current_minutos = Math.floor(audio.currentTime/60)
    let current_segundos = Math.floor(audio.currentTime - current_minutos * 60)

    let width = parseFloat((audio.currentTime / audio.duration) * 100)
    seek.value = width
    console.log(seek.value)
    let seekb = seek.value
    // console.log(width)
    bar2.style.width=`${seekb}%`
    dot.style.left=`${seekb}%`
    if(current_segundos < 10){
        current_segundos = `0${current_segundos}`
    }
    current_time.innerText=`${current_minutos}:${current_segundos}`
})
//Actualizar duración total de la canción
audio.addEventListener("loadedmetadata", ()=>{
    seek.max=audio.duration
    let duracion_min = Math.floor(audio.duration/60)
    let duracion_segundos = Math.floor(audio.duration - duracion_min * 60);
    if(duracion_segundos < 10){
        duracion_segundos = `0${duracion_segundos}`
    }   
    end_time.innerText=`${duracion_min}:${duracion_segundos}`
})


seek.addEventListener("input", ()=>{
    audio.currentTime=seek.value
})

audio.addEventListener("ended", ()=>{
    bar2.style.width='0%'
    dot.style.left='0'
    current_time.innerText='0:00'
    end_time.innerText='0:00'
})

volume_input.addEventListener("input", ()=>{
    let valor = volume_input.value
    audio.volume=valor
    let width = valor*100
    volume_bar.style.width=`${width}%`
    volume_dot.style.left=`${width}%`
})

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
 
"use strict"
const main_content = document.getElementById("main-content-dynamic-container")
const loader = document.querySelector(".loader")
const link_inicio = document.getElementById("home-link")
const profile_top_menu = document.querySelector(".profile-menu")
const profile_menu_avatar = document.querySelector(".profile-menu .profile-menu-avatar")

const seek = document.getElementById("seek")
const bar2 = document.getElementById("bar2")
const dot = document.querySelector(".master-play .time-bar .dot")
const volume_input = document.getElementById("volume-slider")
const volume_bar = document.querySelector(".vol-bar")
const volume_dot = document.querySelector(".vol-dot")
const volume_icon = document.querySelector(".volume-icon")
const track_info = document.querySelector(".track-info")

const current_time = document.getElementById("current-time")
const end_time = document.getElementById("end-time")
const play_pause = document.getElementById("play-pause")
const audio = new Audio()
console.log(dot)
let albums = []

initializeUser()
initialVolume()
playerMainState()
// getAlbums()
document.addEventListener("DOMContentLoaded", async ()=>{
    const respuesta = await fetch('../api_audio/canciones.php')
    const datos = await respuesta.json()
    let cancion = datos['datos']
    audio.src=cancion[0].archivo
    track_info.innerHTML=`<img src='${cancion[0].caratula}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${cancion[0].titulo}</span>
                                <span class='track-info-artist'>${cancion[0].grupo}</span>
                            </div>`
                        
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

async function playerMainState(){
    const respuesta = await fetch("../api_audio/player_main_state.php")
    const datos = await respuesta.json()
    console.log(datos)
    const recomendado = {
        foto: datos["grupo_recomendado"],
        id: datos["id_grupo_recomendado"],
        nombre: datos["nombre_grupo_recomendado"]
    }
    main_content.innerHTML=`<div class='banner-recomended w-100 d-flex justify-content-center position-relative'>
        <img src='${recomendado.foto}' class='img-banner-recomended'>
        <h2 class='position-absolute bottom-0'>${recomendado.nombre}</h2>
    </div>`
    // const banner_recomended = main_content.querySelector(".banner-recomended")
    // banner_recomended.style.backgroundImage=`url(${recomendado.foto})`
    // banner_recomended.style.backgroundSize='cover'
    // // banner_recomended.style.backgroundPosition='center'
    // banner_recomended.style.height='45vh'
}

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

    let width = parseFloat(audio.currentTime / audio.duration * 100)
    // console.log(audio.currentTime/audio.duration*100)
    // console.log(audio.duration)
    seek.value = width
    // console.log(seek.value)
    // let seekb = seek.value
    // console.log(width)
    bar2.style.width=`${width}%`
    dot.style.left=`${width}%`
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
    if(audio.volume > 0 && audio.volume <= .25){
        volume_icon.setAttribute("name","volume-low-outline")
    }else if(audio.volume > .25 && audio.volume < .75){
        volume_icon.setAttribute("name", "volume-medium-outline")
    }else if(audio.volume >= .75){
        volume_icon.setAttribute("name", "volume-high-outline")
    }else{
        volume_icon.setAttribute("name", "volume-mute-outline")
    }
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

function initialVolume(){
    document.addEventListener("DOMContentLoaded", ()=>{
        audio.volume='0.5'
        volume_bar.style.width=`50%`
        volume_dot.style.left=`50%`
    })
}
 
async function initializeUser(){
    let user = profile_top_menu.getAttribute("data-user")
    console.log(user)
    const respuesta = await fetch(`../api_audio/info_user.php?usuario=${user}`)
    const datos = await respuesta.json()
    let usuario_datos = datos["datos"]
    profile_menu_avatar.src=usuario_datos[0].foto_avatar
    profile_top_menu.children[0].innerText=`${usuario_datos[0].estilo}`
}
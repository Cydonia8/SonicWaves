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
const player_logo = document.querySelector(".player-logo-color-changer")

const current_time = document.getElementById("current-time")
const end_time = document.getElementById("end-time")
const play_pause = document.getElementById("play-pause")
const audio = new Audio()
console.log(dot)
let albums = []

initialSong()
initializeUser()
initialVolume()
playerMainState()
// getAlbums()

async function initialSong(){
    const respuesta = await fetch('../api_audio/canciones.php')
    const datos = await respuesta.json()
    let cancion = datos['datos']
    audio.src=cancion[0].archivo
    console.log(cancion[0].archivo)
    track_info.innerHTML=`<img src='${cancion[0].caratula}' class='rounded'>
                            <div class='d-flex flex-column'>
                                <span class='track-info-title'>${cancion[0].titulo}</span>
                                <span class='track-info-artist'>${cancion[0].grupo}</span>
                            </div>`
}
// document.addEventListener("DOMContentLoaded", async ()=>{
//     const respuesta = await fetch('../api_audio/canciones.php')
//     const datos = await respuesta.json()
//     let cancion = datos['datos']
//     audio.src=cancion[0].archivo
//     console.log(cancion[0].archivo)
//     track_info.innerHTML=`<img src='${cancion[0].caratula}' class='rounded'>
//                             <div class='d-flex flex-column'>
//                                 <span class='track-info-title'>${cancion[0].titulo}</span>
//                                 <span class='track-info-artist'>${cancion[0].grupo}</span>
//                             </div>`
                        
// })
// button.addEventListener("click", async ()=>{
    
//     await createDOMAlbums(main, albums, createAlbumPreview)
//     loader.classList.add("d-none")
// })
play_pause.addEventListener("click", ()=>{
    if(audio.paused){
        audio.play()
        play_pause.setAttribute("name", "pause-outline")
        player_logo.classList.add("active")
    }else{
        audio.pause()
        play_pause.setAttribute("name", "play-outline")
        player_logo.classList.remove("active")
    }
})
link_inicio.addEventListener("click", (evt)=>{
    evt.preventDefault()
    playerMainState()
})

async function playerMainState(){
    main_content.innerHTML=''
    loader.classList.add("d-flex")
    loader.classList.remove("d-none")
    const respuesta = await fetch("../api_audio/player_main_state.php")
    const datos = await respuesta.json()
    loader.classList.remove("d-flex")
    loader.classList.add("d-none")
    console.log(datos)
    const recomendado = {
        foto: datos["grupo_recomendado"],
        id: datos["id_grupo_recomendado"],
        nombre: datos["nombre_grupo_recomendado"],
        discografica: datos["discografica"]
    }
    let disco = recomendado.discografica == 0 ? '' : 'Artista esencial <ion-icon name="checkmark-circle-outline"></ion-icon>'
    main_content.innerHTML=`<div class='banner-recomended mx-auto d-flex align-items-center flex-column justify-content-end position-relative mb-4'>
        <h2 class='recomended-group-name mb-0'>${recomendado.nombre}</h2>
        <h5 class='ms-3 d-flex align-items-center gap-2 grupo-esencial-badge'>${disco}</h5>
    </div>`
    const banner_recomended = main_content.querySelector(".banner-recomended")
    banner_recomended.style.backgroundImage=`url('${recomendado.foto}')`
    banner_recomended.style.backgroundSize='cover'
    banner_recomended.style.backgroundPosition='center'
    banner_recomended.style.height='40vh'
    const main_albums_container = document.createElement("div")
    main_albums_container.classList.add("main-content-albums-container", "container-fluid", "d-flex", "flex-column", "flex-lg-row", "gap-3", "mb-5")
    main_content.innerHTML+=`<h2 class='ms-4'>Álbumes populares</h2>`
    main_content.appendChild(main_albums_container)
    const main_content_albums_container = main_content.querySelector(".main-content-albums-container")
   
    datos["datos"].forEach(disco=>{
        const div_album_container = document.createElement("div")
        div_album_container.classList.add("d-flex", "flex-column", "justify-content-around", "album-inner-container")
        div_album_container.setAttribute("data-album-id", disco.id)
        div_album_container.innerHTML= `<img src='${disco.foto}' class='img-fluid rounded'>
        <a>${disco.titulo}</a>
        <a class='artist-link' href="${disco.grupo_id}">${disco.autor}</a>`
        main_content_albums_container.appendChild(div_album_container)       
        
    })
    
    const main_artists_container = document.createElement("div")
    main_artists_container.classList.add("d-flex", "flex-column", "flex-lg-row", "gap-3", "main-content-artists-container", "container-fluid")
    main_content.innerHTML+=`<h2 class='ms-4 mt-3'>Artistas populares</h2>`
    main_content.appendChild(main_artists_container)
    const main_content_artists_container = main_content.querySelector(".main-content-artists-container")
    datos["artistas"].forEach(artista=>{
        const div_artist_container = document.createElement("div")
        div_artist_container.setAttribute("data-artist-id", artista.id)
        div_artist_container.addEventListener("click", showGroup)
        div_artist_container.classList.add("d-flex", "flex-column", "justify-content-around", "artist-inner-container")   
        div_artist_container.innerHTML=`<img src='${artista.foto_avatar}' class='img-fluid rounded-circle'>
        <a>${artista.nombre}</a>`
        main_content_artists_container.appendChild(div_artist_container)
    })
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

document.addEventListener("click", (evt)=>{
    const target = evt.target.closest(".album-inner-container"); // Or any other selector.  
    if(target){
      showAlbum(target)
    }
  });

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
    play_pause.setAttribute("name", "play-outline")
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


async function getAlbum(id){
    const respuesta = await fetch(`../api_audio/album_peticion.php?id=${id}`)
    const datos = await respuesta.json()
    return datos["datos"]
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
}

async function showAlbum(target){
    main_content.innerHTML=''
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const id = target.getAttribute("data-album-id")
    const respuesta = await fetch(`../api_audio/album_peticion.php?id=${id}`)
    const datos = await respuesta.json()
    loader.classList.add("d-none")
    loader.classList.remove("d-flex")
    const datos_album = datos["datos_album"]
    
    const section_album_head = document.createElement("section")
    section_album_head.classList.add("container-fluid", "d-flex", "album-page-header", "gap-3", "align-items-center", "p-3", "border-bottom")
    section_album_head.innerHTML=`<img src='${datos_album[0].foto}' class='album-page-portada'>
                                    <div class='d-flex flex-column gap-3'>
                                        <h1>${datos_album[0].titulo}</h1>
                                        <div class='d-flex align-items-center gap-2'>
                                            <img src='${datos_album[0].avatar}' class='avatar-album-page'>
                                            <h3 class='m-0'>${datos_album[0].autor}</h3>
                                        </div>
                                        <h4>Lanzado el ${datos_album[0].lanzamiento}</h4>
                                        <div class='d-flex gap-4'>
                                            <i class="fa-regular fa-heart add-favorite-album"></i>
                                            <i class="fa-regular fa-comment add-album-review"></i>
                                        </div>
                                    </div>`
    main_content.appendChild(section_album_head)
    const lista_canciones = datos["lista_canciones"]
    const section_lista_canciones = document.createElement("section")
    section_lista_canciones.classList.add("p-4", "d-flex", "flex-column", "gap-3")
    console.log(lista_canciones)
    lista_canciones.forEach((cancion, index)=>{
        let indice = index+1
        const cancion_container = document.createElement("div")
        cancion_container.classList.add("d-flex", "justify-content-between", "cancion-row")
        cancion_container.innerHTML=`<div class='d-flex gap-3'>
                                        <span>${indice}</span>
                                        <h5 class='m-0'>${cancion.titulo}</h5>
                                    </div>
                                    <span>${cancion.duracion}</span>`
        cancion_container.addEventListener("click", ()=>{
            console.log("click")
        })                                    
        section_lista_canciones.appendChild(cancion_container)
    })
    main_content.appendChild(section_lista_canciones)
}

async function showGroup(evt){
    main_content.innerHTML=''
    loader.classList.remove("d-none")
    loader.classList.add("d-flex")
    const id = evt.currentTarget.getAttribute("data-artist-id")
    const respuesta = await fetch(`../api_audio/artista_peticion.php?id=${id}`)
    const datos = await respuesta.json()
    loader.classList.add("d-none")
    loader.classList.remove("d-flex")
    const datos_grupo = datos["datos_grupo"]
    
    let disco = datos_grupo[0].discografica == 0 ? '' : 'Artista esencial <ion-icon name="checkmark-circle-outline"></ion-icon>'
    const section_artist_head = document.createElement("section")
    const div_artist_avatar = document.createElement("div")
    section_artist_head.innerHTML=`<div class='d-flex flex-column align-items-start'><h1 class='ms-4 section-artist-title mb-0'>${datos_grupo[0].nombre}</h1>
    <h5 class='ms-4 d-flex align-items-center grupo-esencial-badge'>${disco}</h5></div>`
    section_artist_head.classList.add("d-flex","justify-content-end", "flex-column")
    div_artist_avatar.classList.add("position-absolute")
    div_artist_avatar.style.width='100%'
    div_artist_avatar.style.height='100%'
    div_artist_avatar.innerHTML=`<img class='position-absolute rounded-circle section-artist-avatar' src='${datos_grupo[0].foto_avatar}'>`
    section_artist_head.appendChild(div_artist_avatar)
    section_artist_head.classList.add("w-100")
    section_artist_head.style.backgroundImage=`url('${datos_grupo[0].foto}')`
    section_artist_head.style.height='45vh'
    section_artist_head.style.backgroundSize='cover'
    section_artist_head.style.backgroundPosition='center'
    section_artist_head.style.position='absolute'
    section_artist_head.style.top='0'
    main_content.appendChild(section_artist_head)
}

function clickOnSong(){

}
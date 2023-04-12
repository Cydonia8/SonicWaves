const audios = document.querySelectorAll("audio");
const img = document.querySelectorAll(".cancion-prev .img-fluid")
// const height = img.clientHeight
// const width = img.clientWidth
console.log(img)

img.forEach(imagen => {
    let height = imagen.clientHeight
    let width = imagen.clientWidth
    imagen.addEventListener("mousemove", (evento) => {
        const {layerX, layerY} = evento
    
        const yRotation = ((layerX - width / 2) / width) * 20
        const xRotation = ((layerY - height / 2) / height) * 20
    
        const string = `perspective(500px)
                        scale(1.05)
                        rotateX(${xRotation}deg) 
                        rotateY(${yRotation}deg)`
        imagen.style.transform = string
    })

    imagen.addEventListener("mouseout", () => {
        imagen.style.transform = `
        perspective(0px)
        scale(1)
        rotateX(0deg)
        rotateY(0deg)
        `
    })
})

audios.forEach((audio) => {
    let start = 30
    audio.currentTime=start
    audio.addEventListener("timeupdate", (e) => {
        let currentTime = e.target.currentTime
        if (currentTime > start + 15){
            audio.pause()
        }
    })
})
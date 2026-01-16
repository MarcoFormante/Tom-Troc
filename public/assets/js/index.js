

document.addEventListener("DOMContentLoaded",()=>{
    const messagesContainer = document.querySelector('.messages-container')
    const input = document.querySelector("input[type=file]")
    const image =  document.querySelector("img")
    const menu = document.querySelector(".menu-hamburger-container");

    if (input && image) {
            input.onchange = ()=>{
            image.src = URL.createObjectURL(input.files[0])
        }
    }

    const containers = document.querySelectorAll(".form-input-container, select")

    containers.forEach((container)=>{
        const input = container.querySelector(".error-input-focus")
        if (input) {
            input.oninput = ()=>{
                if(input.classList.contains("error-input-focus")){
                    input.classList.remove("error-input-focus")
                    container.dataset.error = "";
                }
            }
        }
    })    

    if (messagesContainer) {
        messagesContainer.scrollTo({
            "top":window.innerHeight,
            "behavior":"smooth"
        });
    }

    if (menu) {
        const navMobileContainer = document.querySelector(".header-mobile-navigation")
        const closeNavMobileBtn =  document.querySelector(".close-menu-btn")

        menu.onclick = () => {
          navMobileContainer.classList.toggle("header-mobile-navigation-active")
        }

        closeNavMobileBtn.onclick = () => {
            navMobileContainer.classList.toggle("header-mobile-navigation-active")
        }

         window.addEventListener("resize",()=>{
            if (window.innerWidth > 1024) {
                navMobileContainer.classList.remove("header-mobile-navigation-active")
            }
        })
    }
})



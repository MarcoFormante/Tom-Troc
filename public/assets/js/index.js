

document.addEventListener("DOMContentLoaded",()=>{

    if (document.getElementById("profileImage")) {
            profileImage.onchange = ()=>{
            userImg.src = URL.createObjectURL(profileImage.files[0]);
        }
    }

    const containers = document.querySelectorAll(".form-input-container");

    containers.forEach((container)=>{
        const input = container.querySelector(".error-input-focus");
        if (input) {
            input.oninput = ()=>{
                if(input.classList.contains("error-input-focus")){
                    input.classList.remove("error-input-focus")
                    container.dataset.error = ""
                }
            }
        }
    })    

})


